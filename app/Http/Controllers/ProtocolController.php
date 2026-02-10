<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mission;
use App\Models\Training;
use Carbon\Carbon;

class ProtocolController extends Controller
{
    public function index()
    {
        // 1. Obtener misión activa del usuario
        $activeMission = Auth::user()->activeMission()->first();
        
        // 2. Seleccionar 1 de cada dificultad
        // Si hay una misión activa, esa DEBE ser la que se muestre en su categoría.
        
        // Easy
        if ($activeMission && $activeMission->difficulty === 'easy') {
            $easy = $activeMission;
        } else {
            $easy = Mission::daily()->where('difficulty', 'easy')->inRandomOrder()->first();
        }

        // Medium
        if ($activeMission && $activeMission->difficulty === 'medium') {
            $medium = $activeMission;
        } else {
            $medium = Mission::daily()->where('difficulty', 'medium')->inRandomOrder()->first();
        }

        // Hard
        if ($activeMission && $activeMission->difficulty === 'hard') {
            $hard = $activeMission;
        } else {
            $hard = Mission::daily()->where('difficulty', 'hard')->inRandomOrder()->first();
        }

        // Collection con las 3 misiones
        $missions = collect([$easy, $medium, $hard])->filter(); // filter para eliminar nulos si faltan misiones

        return view('protocols', compact('missions', 'activeMission'));
    }

    public function start($id)
    {
        $user = Auth::user();

        // 1. Cleanup: Detach ONLY the current active daily mission, leaving personalized trainings untouched
        $currentDailies = $user->activeMission()->pluck('missions.id');
        $user->missions()->detach($currentDailies);

        // 2. Find a random training of the same difficulty
        $mission = Mission::findOrFail($id);
        
        // Search for a random training of the same difficulty (Excluding Race-Specific Programs)
        $training = Training::where('difficulty', $mission->difficulty)
            ->where('title', 'not like', 'Saiyan%')
            ->where('title', 'not like', 'Namek%')
            ->where('title', 'not like', 'Frost%')
            ->where('title', 'not like', 'Human%')
            ->inRandomOrder()
            ->first();
        
        // Asignar misión por 24 horas + entrenamiento
        $user->missions()->attach($id, [
            'expires_at' => Carbon::now()->addHours(24),
            'completed' => false,
            'training_id' => $training ? $training->id : null,
            'exercises_progress' => json_encode([]),
        ]);

        return back()->with('success', '¡Protocolo iniciado! Entrenamiento asignado: ' . ($training ? $training->title : 'Estándar'));
    }

    public function cancel($id)
    {
        $user = Auth::user();
        
        // Detach the specific mission (Abandon)
        // Note: If multiple instances of same mission exist, detach($id) removes all.
        // Assuming unique mission assignment per type for now.
        $user->missions()->detach($id);

        return redirect()->route('dashboard')->with('success', 'Protocolo cancelado.');
    }
}
