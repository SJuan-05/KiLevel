<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mission;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Protocolo Diario Activo (Hero Section)
        $activeDaily = $user->activeMission()->first();

        // Entrenamientos Activos (Mis Entrenamientos)
        $activeTrainings = $user->activePrograms()->get();

        // Recomendados de la tienda (Nuevos títulos variados)
        $allShopItems = [
            ['id' => 'title_saiyan_elite', 'name' => 'Élite Saiyan', 'price' => 500, 'description' => 'Solo para los guerreros de clase alta.', 'icon' => 'bi-star-fill'],
            ['id' => 'title_earth_protector', 'name' => 'Protector de la Tierra', 'price' => 1500, 'description' => 'Juraste defender este planeta.', 'icon' => 'bi-shield-fill-check'],
            ['id' => 'title_legendary_warrior', 'name' => 'Guerrero Legendario', 'price' => 3000, 'description' => 'Tu nombre será eterno.', 'icon' => 'bi-trophy-fill'],
            ['id' => 'title_prince_pride', 'name' => 'Príncipe del Orgullo', 'price' => 8000, 'description' => 'Tu orgullo es tu mayor arma.', 'icon' => 'bi-gem'],
        ];

        // Seleccionar 2 aleatorios o los que no tenga
        $unlocked = $user->unlocked_titles ?? [];
        $recommendedItems = [];
        foreach ($allShopItems as $item) {
            if (!in_array($item['name'], $unlocked)) {
                $recommendedItems[] = $item;
            }
            if (count($recommendedItems) >= 2) break;
        }

        // Si ya tiene todo lo básico, mostrar los de gama alta
        if (count($recommendedItems) < 2) {
            $recommendedItems[] = ['id' => 'title_god_ki', 'name' => 'Ki Divino', 'price' => 15000, 'description' => 'Poder de los dioses.', 'icon' => 'bi-sun-fill'];
        }

        foreach ($recommendedItems as &$item) {
            $item['owned'] = in_array($item['name'], $unlocked);
        }

        return view('dashboard', compact('user', 'activeDaily', 'activeTrainings', 'recommendedItems'));
    }
}
