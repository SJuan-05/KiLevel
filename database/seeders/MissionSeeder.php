<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('missions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        DB::table('missions')->insert([
            // --- EASY (3) ---
            [
                'title' => 'DESPERTAR',
                'description' => 'Activación muscular y flujo de Ki básico. Ideal para comenzar el día y preparar el cuerpo.',
                'xp_reward' => 50,
                'difficulty' => 'easy',
                'active' => true,
                'type' => 'daily',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'CALENTAMIENTO DE ROSHI',
                'description' => 'Rutina matutina de la Escuela Tortuga. Entrega leche, cultiva fuerza.',
                'xp_reward' => 60,
                'difficulty' => 'easy',
                'active' => true,
                'type' => 'daily',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'MEDITACIÓN ACTIVA',
                'description' => 'Conecta mente y cuerpo con movimientos fluidos y controlados.',
                'xp_reward' => 55,
                'difficulty' => 'easy',
                'active' => true,
                'type' => 'daily',
                'created_at' => $now, 'updated_at' => $now,
            ],

            // --- MEDIUM (3) ---
            [
                'title' => 'KAIO-KEN',
                'description' => 'Aumenta la intensidad. Control de respiración y resistencia bajo presión.',
                'xp_reward' => 150,
                'difficulty' => 'medium',
                'active' => true,
                'type' => 'daily',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'GRAVEDAD X10',
                'description' => 'El primer paso para superar tus límites terrícolas. Pesado y constante.',
                'xp_reward' => 180,
                'difficulty' => 'medium',
                'active' => true,
                'type' => 'daily',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'ENTRENAMIENTO EN LA TORRE',
                'description' => 'Mejora tu agilidad y reflejos persiguiendo al gato sagrado.',
                'xp_reward' => 160,
                'difficulty' => 'medium',
                'active' => true,
                'type' => 'daily',
                'created_at' => $now, 'updated_at' => $now,
            ],

            // --- HARD (3) ---
            [
                'title' => 'LÍMITE BREAKER',
                'description' => 'Solo para élite. Fallo muscular garantizado y recuperación al límite.',
                'xp_reward' => 400,
                'difficulty' => 'hard',
                'active' => true,
                'type' => 'daily',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'SALA DEL TIEMPO',
                'description' => 'Un año de dolor en un día. Resistencia mental y física absoluta.',
                'xp_reward' => 500,
                'difficulty' => 'hard',
                'active' => true,
                'type' => 'daily',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'SUPER SAIYAN BLUE',
                'description' => 'Control perfecto del Ki Divino. Explosividad máxima sin desperdicio de energía.',
                'xp_reward' => 600,
                'difficulty' => 'hard',
                'active' => true,
                'type' => 'daily',
                'created_at' => $now, 'updated_at' => $now,
            ],

            // --- PROGRAMS (4 - One per Race) ---
            [
                'title' => 'CLASE HUMANA: DEFENSA TERRESTRE',
                'description' => 'Programa especializado para terrícolas. Equilibrio entre técnica, agilidad y espíritu inquebrantable.',
                'xp_reward' => 1500,
                'difficulty' => 'easy',
                'active' => true,
                'type' => 'program',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'CLASE NAMEK: REGENERACIÓN',
                'description' => 'Programa especializado para namekianos. Enfoque en recuperación activa, flexibilidad y mente.',
                'xp_reward' => 1500,
                'difficulty' => 'medium',
                'active' => true,
                'type' => 'program',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'CLASE SAIYAN: PODER PURO',
                'description' => 'Programa especializado para saiyans. Intensidad brutal para romper límites y provocar zenkai.',
                'xp_reward' => 1500,
                'difficulty' => 'hard',
                'active' => true,
                'type' => 'program',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'CLASE FROST: CONQUISTA',
                'description' => 'Programa especializado para raza de Frost. Eficiencia táctica y dominación física.',
                'xp_reward' => 1500,
                'difficulty' => 'hard',
                'active' => true,
                'type' => 'program',
                'created_at' => $now, 'updated_at' => $now,
            ],
        ]);
    }
}
