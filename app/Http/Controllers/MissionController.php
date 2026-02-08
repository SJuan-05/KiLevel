<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MissionController extends Controller
{
    public function index()
    {
        $missions = [
            ['title' => 'Entrena 30 minutos', 'reward' => '50 XP'],
            ['title' => 'Camina 5km', 'reward' => '100 XP'],
            ['title' => 'Medita 10 minutos', 'reward' => '30 XP'],
        ];

        return view('missions.index', compact('missions'));
    }
}
