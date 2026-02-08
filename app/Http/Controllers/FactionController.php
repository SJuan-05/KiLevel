<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FactionController extends Controller
{
    public function index()
    {
        $factions = Faction::withCount('members')->orderByDesc('members_count')->get();
        return view('factions.index', compact('factions'));
    }

    public function create()
    {
        return view('factions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:factions|max:255',
            'description' => 'nullable|max:1000',
        ]);

        $user = Auth::user();

        if ($user->faction_id) {
            return back()->with('error', 'Ya perteneces a una facción. Abandónala primero.');
        }

        $faction = Faction::create([
            'name' => $request->name,
            'description' => $request->description,
            'leader_id' => $user->id,
        ]);

        // Asignar al creador como miembro y LÍDER automáticamente
        $user->update([
            'faction_id' => $faction->id,
            'faction_role' => 'leader'
        ]);

        return redirect()->route('factions.index')->with('success', '¡Facción creada con éxito! Lidera con honor.');
    }

    public function show($id)
    {
        $faction = Faction::with('leader')->findOrFail($id);

        // EXTRA FIX: Si el líder actual visualiza su facción pero no tiene el faction_id o rol correcto, lo reparamos.
        if (Auth::check() && Auth::id() == $faction->leader_id) {
            if (Auth::user()->faction_id != $faction->id || Auth::user()->faction_role != 'leader') {
                Auth::user()->update([
                    'faction_id' => $faction->id,
                    'faction_role' => 'leader'
                ]);
            }
        }

        // Cargamos los miembros con el nuevo orden de 4 rangos
        $faction->load(['members' => function($query) {
            $query->orderByRaw("FIELD(faction_role, 'leader', 'commander', 'veteran', 'member')");
        }]);

        return view('factions.show', compact('faction'));
    }

    public function updateRank(Request $request, $user_id)
    {
        $targetUser = User::findOrFail($user_id);
        $authUser = Auth::user();

        if (!$authUser->faction_id || $authUser->faction_id != $targetUser->faction_id) {
            return back()->with('error', 'No tienes permiso para esto.');
        }

        // Pesos de rangos
        $ranks = [
            'leader' => 10,
            'commander' => 5,
            'veteran' => 3,
            'member' => 1
        ];

        $authWeight = $ranks[$authUser->faction_role] ?? 0;
        $targetWeight = $ranks[$targetUser->faction_role] ?? 0;
        $newWeight = $ranks[$request->rank] ?? 0;

        // Reglas:
        // 1. Solo puedes editar a alguien con rango inferior al tuyo
        // 2. No puedes dar un rango igual o superior al tuyo
        if ($authWeight <= $targetWeight) {
            return back()->with('error', 'No puedes editar a un superior o igual.');
        }

        if ($authWeight <= $newWeight) {
            return back()->with('error', 'No puedes otorgar un rango superior o igual al tuyo.');
        }

        $targetUser->update(['faction_role' => $request->rank]);

        return back()->with('success', "Rango de {$targetUser->name} actualizado a " . strtoupper($request->rank));
    }

    public function join($id)
    {
        $user = Auth::user();

        if ($user->faction_id) {
            return back()->with('error', 'Ya tienes una facción.');
        }

        $user->update([
            'faction_id' => $id,
            'faction_role' => 'member'
        ]);

        return back()->with('success', 'Te has unido a la facción como Guerrero.');
    }

    public function leave($id)
    {
        $user = Auth::user();

        if ($user->faction_id != $id) {
            return back()->with('error', 'No perteneces a esta facción.');
        }

        // Si es el líder, no puede abandonar (por ahora, lógica simple)
        $faction = Faction::find($id);
        if ($faction->leader_id == $user->id) {
            return back()->with('error', 'El líder no puede abandonar su facción. Debes eliminarla o pasar el liderazgo.');
        }

        $user->update(['faction_id' => null]);

        return back()->with('success', 'Has abandonado la facción.');
    }
}
