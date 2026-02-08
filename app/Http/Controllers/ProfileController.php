<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return $this->showProfile(Auth::user());
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return $this->showProfile($user);
    }

    private function showProfile($user)
    {
        // Calculamos progreso (Ej: 1000 XP para subir de nivel)
        $xpNextLevel = 1000;
        $progress = ($user->xp / $xpNextLevel) * 100;

        // Lista base de títulos + desbloqueados
        $defaultTitles = ['Aprendiz Tortuga', 'Guerrero Z', 'Super Saiyan'];
        $unlocked = $user->unlocked_titles ?? [];
        
        // Unir y eliminar duplicados
        $availableTitles = array_unique(array_merge($defaultTitles, $unlocked));

        // Obtener actividad reciente (últimas misiones completadas)
        $recentActivity = $user->missions()
            ->wherePivot('completed', true)
            ->orderBy('user_mission.updated_at', 'desc')
            ->take(5)
            ->get();

        return view('profile.index', compact('user', 'progress', 'availableTitles', 'recentActivity'));
    }

    public function update(Request $request)
    {
        // BUSCAMOS EL USUARIO EXPLÍCITAMENTE COMO MODELO ELOQUENT
        $user = User::findOrFail(Auth::id());

        // 1. Validar datos
        $request->validate([
            'name' => 'required|string|max:255',
            'current_title' => 'required|string|max:100',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072', // Máx 3MB
        ]);

        // 2. Actualizar textos
        $user->name = $request->name;
        $user->current_title = $request->current_title;

        // 3. Lógica del Avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 4. Guardar cambios en DB
        $user->save();

        return redirect()->route('profile.index')->with('success', '¡Identificación de Guerrero actualizada!');
    }
}
