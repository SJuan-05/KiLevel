<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Mission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    /**
     * Show the specific training session.
     */
    public function show($id)
    {
        $training = Training::find($id);

        if (!$training) {
            return redirect()->route('dashboard')->with('error', 'Entrenamiento no encontrado.');
        }

        // Determinar si es Daily o Program
        $user = Auth::user();
        
        // Buscamos la misión activa ligada a este entrenamiento para saber el tipo
        $mission = $user->activeMissions()
                        ->wherePivot('training_id', $id)
                        ->first();

        // Determinar si es programa avanzado
        $isProgram = false;
        
        if ($mission && $mission->type === 'program') {
            $isProgram = true;
        } elseif (preg_match('/(CLASE|SAIYAN|NAMEK|FROST|HUMAN|HUMANA)/i', $training->title)) {
            $isProgram = true;
        }

        // Obtener el progreso actual de los ejercicios
        $currentProgress = [];
        if ($mission) {
            $currentProgress = $mission->pivot->exercises_progress ? json_decode($mission->pivot->exercises_progress, true) : [];
        }

        return view('training.show', compact('training', 'isProgram', 'currentProgress'));
    }

    public function selectRace(Request $request)
    {
        $request->validate([
            'race' => 'required|in:saiyan,namek,frost,human'
        ]);

        $user = Auth::user();
        $user->update(['race' => $request->race]);

        // 1. Determine Difficulty based on Race
        $difficultyMap = [
            'saiyan' => 'hard',
            'frost' => 'hard',
            'namek' => 'medium',
            'human' => 'easy',
        ];
        $difficulty = $difficultyMap[$request->race] ?? 'easy';

        // 1.5 SINGLE TRAINING PER RACE CHECK
        // Check if user already has an active PROGRAM mission for this SPECIFIC race
        $existing = $user->activePrograms()->get()->filter(function($m) use ($request) {
            $t = \App\Models\Training::find($m->pivot->training_id);
            return $t && preg_match('/' . $request->race . '/i', $t->title);
        })->first();

        if ($existing) {
             return redirect()->route('training.show', $existing->pivot->training_id)
                ->with('info', 'Ya tienes un entrenamiento de clase ' . ucfirst($request->race) . ' activo. ¡Continúa tu progreso!');
        }

        // 2. Find the corresponding PROGRAM Mission
        $mission = Mission::program()
            ->where('title', 'like', '%CLASE ' . strtoupper($request->race) . '%')
            ->first();

        if (!$mission) {
             $mission = Mission::program()->where('difficulty', $difficulty)->first();
        }

        // 3. Find a Training specific to that race
        $training = Training::where('title', 'like', ucfirst($request->race) . '%')
            ->inRandomOrder()
            ->first();

        if (!$training) {
            $training = Training::where('difficulty', $difficulty)->inRandomOrder()->first();
        }

        if ($mission && $training) {
            // Cleanup: Detach ONLY previous uncompleted programs, keeping daily protocols intact
            $currentPrograms = $user->activePrograms()->pluck('missions.id');
            $user->missions()->detach($currentPrograms);

            $user->missions()->attach($mission->id, [
                'expires_at' => Carbon::now()->addYears(10),
                'completed' => false,
                'training_id' => $training->id,
                'exercises_progress' => json_encode([]), 
            ]);

            return redirect()->route('training.show', $training->id)
                ->with('success', '¡Protocolo Iniciado! Tu entrenamiento de clase ' . ucfirst($request->race) . ' está listo.');
        }

        // Fallback
        return redirect()->route('dashboard')->with('error', 'No se pudo iniciar el protocolo. Verifica la base de datos.');
    }

    public function toggleExercise(Request $request, $id)
    {
        // $id is the training_id, but we need to update the User Active Mission pivot
        $user = Auth::user();
        $activeMission = $user->activeMissions()->wherePivot('training_id', $id)->first();

        if ($activeMission) {
            $currentProgress = $activeMission->pivot->exercises_progress ? json_decode($activeMission->pivot->exercises_progress, true) : [];
            $exerciseIndex = (int) $request->index;

            if (in_array($exerciseIndex, $currentProgress)) {
                // Remove (unchecked)
                $currentProgress = array_diff($currentProgress, [$exerciseIndex]);
            } else {
                // Add (checked)
                $currentProgress[] = $exerciseIndex;
            }

            // Clean up and re-index array
            $currentProgress = array_values(array_unique($currentProgress));

            DB::table('user_mission')
                ->where('id', $activeMission->pivot->id)
                ->update([
                    'exercises_progress' => json_encode($currentProgress),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);

            return response()->json(['success' => true, 'progress' => $currentProgress]);
        }

        return response()->json(['success' => false, 'message' => 'No active mission found.']);
    }

    public function complete(Request $request, $id)
    {
        $user = Auth::user();
        
        // 1. Encuentra la misión activa que corresponde a este entrenamiento
        // Usamos activeMissions() (GENÉRICO) para buscar tanto diarias como programas
        $activeMission = $user->activeMissions()
            ->wherePivot('training_id', $id)
            ->wherePivot('completed', false)
            ->first();

        if (!$activeMission) {
            // Si el usuario refresca después de completar, puede que ya esté completa.
            // Redirigir al dashboard para evitar bucle de error.
            return redirect()->route('dashboard')->with('info', 'El protocolo ya fue completado o no existe.');
        }

        // 2. Seguridad: Verificar que todos los ejercicios estén completados
        // Validamos usando el INPUT del formulario (lo que el usuario marcó)
        // en lugar de la DB, ya que las nuevas vistas no guardan progreso parcial vía AJAX.
        $training = Training::find($id);
        $totalExercises = count($training->exercises ?? []);
        $exercisesInput = $request->input('exercises', []);
        
        if (count($exercisesInput) < $totalExercises) {
            return redirect()->back()->with('error', '¡No hagas trampas! Completa todos los ejercicios primero.');
        }

        // 3. Recompensa
        // La XP viene de la Misión (Protocolo), no del entrenamiento en sí.
        $xpGain = $activeMission->xp_reward;

        // 4. Actualizar Usuario (Sumar XP y Zeni)
        $oldLevel = $user->level;
        
        // Zeni calcul: Base 50 + (10 * Nivel de Dificultad)
        // Dificultad: Puede estar en Training o Mission
        $difficulty = $training->difficulty ?? 'easy';
        $zeniMultiplier = match($difficulty) {
            'easy' => 1,
            'medium' => 2,
            'hard' => 3,
            'god' => 5,
            default => 1
        };
        $zeniGain = 50 * $zeniMultiplier;
        
        // Bonus por Plan
        $planMultiplier = match($user->plan) {
            'kaio' => 1.5,
            'whis' => 2,
            default => 1
        };
        $zeniGain = (int) ($zeniGain * $planMultiplier);

        $user->addXp($xpGain);
        $finalXp = (int) ($xpGain * ($user->xp_multiplier ?? 1.0));
        $user->zeni = ($user->zeni ?? 0) + $zeniGain; // Sumar Zeni
        
        $newLevel = $user->level;

        // 5. Marcar Misión como Completada
        DB::table('user_mission')
            ->where('id', $activeMission->pivot->id)
            ->update([
                'completed' => true,
                'updated_at' => Carbon::now(),
            ]);

        $user->save();

        // Mensaje final
        $mult = $user->xp_multiplier ?? 1.0;
        $multText = ($mult > 1.0) ? " (x{$mult})" : "";
        $message = "¡Protocolo Finalizado! Has ganado +{$finalXp} XP{$multText} y +{$zeniGain} Zeni.";
        if ($newLevel > $oldLevel) {
            $message .= " ¡INCREÍBLE! Has subido al Nivel {$newLevel}.";
        }

        return redirect()->route('dashboard')->with('success', $message);
    }
}
