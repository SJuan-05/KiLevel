<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrainingSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // EASY TRAININGS
        DB::table('trainings')->insert([
            [
                'title' => 'Calistenia Básica A',
                'description' => 'Rutina de peso corporal para principiantes. Enfocada en técnica.',
                'difficulty' => 'easy',
                'exercises' => json_encode([
                    ['name' => 'Flexiones', 'reps' => '3x10', 'rest' => '60s'],
                    ['name' => 'Sentadillas', 'reps' => '3x15', 'rest' => '60s'],
                    ['name' => 'Plancha Abdominal', 'reps' => '3x30s', 'rest' => '60s'],
                    ['name' => 'Jumping Jacks', 'reps' => '3x50', 'rest' => '60s'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'Movilidad y Core B',
                'description' => 'Activación de la zona media y mejora del rango de movimiento.',
                'difficulty' => 'easy',
                'exercises' => json_encode([
                    ['name' => 'Bird-Dog', 'reps' => '3x12', 'rest' => '45s'],
                    ['name' => 'Puente de Glúteo', 'reps' => '3x15', 'rest' => '45s'],
                    ['name' => 'Dead Bug', 'reps' => '3x20', 'rest' => '45s'],
                    ['name' => 'Estiramiento Gato-Vaca', 'reps' => '2 min', 'rest' => '0s'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ]
        ]);

        // MEDIUM TRAININGS
        DB::table('trainings')->insert([
            [
                'title' => 'Hipertrofia Saiyan A',
                'description' => 'Volumen moderado para estimular crecimiento muscular.',
                'difficulty' => 'medium',
                'exercises' => json_encode([
                    ['name' => 'Flexiones Diamante', 'reps' => '4x12', 'rest' => '90s'],
                    ['name' => 'Zancadas Búlgaras', 'reps' => '4x10/pierna', 'rest' => '90s'],
                    ['name' => 'Fondos en Silla/Paralelas', 'reps' => '4x12', 'rest' => '90s'],
                    ['name' => 'Elevación de Talones', 'reps' => '4x20', 'rest' => '60s'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'Resistencia Namekiana B',
                'description' => 'Circuito metabólico para mejorar la estamina.',
                'difficulty' => 'medium',
                'exercises' => json_encode([
                    ['name' => 'Burpees', 'reps' => '4x15', 'rest' => '60s'],
                    ['name' => 'Mountain Climbers', 'reps' => '4x40', 'rest' => '60s'],
                    ['name' => 'Sentadilla con Salto', 'reps' => '4x15', 'rest' => '60s'],
                    ['name' => 'Plancha Lateral', 'reps' => '4x45s/lado', 'rest' => '60s'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ]
        ]);

        // HARD TRAININGS
        DB::table('trainings')->insert([
            [
                'title' => 'Gravedad x100 A',
                'description' => 'Alta intensidad. Solo para guerreros avanzados.',
                'difficulty' => 'hard',
                'exercises' => json_encode([
                    ['name' => 'Flexiones a una mano (o Archer)', 'reps' => '5x8/lado', 'rest' => '120s'],
                    ['name' => 'Pistol Squats', 'reps' => '5x5/pierna', 'rest' => '120s'],
                    ['name' => 'Dominadas (si hay barra) o Remo Mesa', 'reps' => '5xFallo', 'rest' => '120s'],
                    ['name' => 'L-Sit Hold', 'reps' => '5xMax', 'rest' => '90s'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'Fallo Muscular Total B',
                'description' => 'Destrucción total de fibras. Protocolo de fallo.',
                'difficulty' => 'hard',
                'exercises' => json_encode([
                    ['name' => 'Flexiones Explosivas', 'reps' => '8x10', 'rest' => '45s'],
                    ['name' => 'Saltos al Cajón (o superficie alta)', 'reps' => '6x10', 'rest' => '60s'],
                    ['name' => 'Hollow Body Rocks', 'reps' => '4x50', 'rest' => '60s'],
                    ['name' => 'Sprints en sitio', 'reps' => '10x30s', 'rest' => '30s'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ]
        ]);

        // --- NEW ELABORATED RACE TRAININGS ---

        // 1. HUMAN (Difficulty: EASY - Technique & Endurance)
        DB::table('trainings')->insert([
            [
                'title' => 'Human: Escuela Tortuga A',
                'description' => 'Entrenamiento clásico del Maestro Roshi. Volumen alto, peso corporal, enfoque en resistencia mental.',
                'difficulty' => 'easy',
                'exercises' => json_encode([
                    ['name' => 'Saltos de Cuerda (Imaginaria si no hay)', 'reps' => '5 min', 'rest' => '30s'],
                    ['name' => 'Flexiones Estrictas', 'reps' => '4x15', 'rest' => '45s'],
                    ['name' => 'Caminata de Oso', 'reps' => '3x20m', 'rest' => '60s'],
                    ['name' => 'Sentadilla Búlgara', 'reps' => '3x12/pierna', 'rest' => '60s'],
                    ['name' => 'Plancha Abdominal Isometrica', 'reps' => '3x45s', 'rest' => '45s'],
                    ['name' => 'Sprints Suaves', 'reps' => '5x50m', 'rest' => '30s']
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'Human: Defensa Terrestre B',
                'description' => 'Preparación táctica y agilidad. Movimientos rápidos para esquivar y contraatacar.',
                'difficulty' => 'easy',
                'exercises' => json_encode([
                    ['name' => 'Burpees sin flexión', 'reps' => '3x20', 'rest' => '45s'],
                    ['name' => 'Boxeo de Sombra', 'reps' => '3x3 min', 'rest' => '60s'],
                    ['name' => 'Zancadas Laterales', 'reps' => '3x15/lado', 'rest' => '45s'],
                    ['name' => 'Elevación de Piernas (Suelo)', 'reps' => '4x15', 'rest' => '45s'],
                    ['name' => 'Superman (Lumbares)', 'reps' => '3x20', 'rest' => '30s'],
                    ['name' => 'Carrera Continua', 'reps' => '15 min', 'rest' => '0s']
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ]
        ]);

        // 2. NAMEK (Difficulty: MEDIUM - Regen, Flexibility, Mind)
        DB::table('trainings')->insert([
            [
                'title' => 'Namek: Fusión Mística A',
                'description' => 'Conexión mente-músculo. Movimientos lentos y controlados con tensión isométrica constante.',
                'difficulty' => 'medium',
                'exercises' => json_encode([
                    ['name' => 'Flexiones Hindú (Dive Bombers)', 'reps' => '4x10', 'rest' => '60s'],
                    ['name' => 'Sentadilla Cosaca', 'reps' => '4x8/lado', 'rest' => '60s'],
                    ['name' => 'Dominadas (o Remo) con Pausa', 'reps' => '4x8 (2s pausa)', 'rest' => '90s'],
                    ['name' => 'Dragon Flags (o progresiones)', 'reps' => '3xMax', 'rest' => '90s'],
                    ['name' => 'Estiramiento Dinámico de Cadera', 'reps' => '3x1 min', 'rest' => '30s'],
                    ['name' => 'Meditación Post-Entreno', 'reps' => '5 min', 'rest' => '0s']
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'Namek: Regeneración B',
                'description' => 'Recuperación activa y fortalecimiento del core profundo. Ideal para días de carga media.',
                'difficulty' => 'medium',
                'exercises' => json_encode([
                    ['name' => 'Hollow Body Hold', 'reps' => '5x45s', 'rest' => '45s'],
                    ['name' => 'Puente Glúteo a 1 pierna', 'reps' => '4x12/lado', 'rest' => '45s'],
                    ['name' => 'L-Sit (Suelo o Paralelas)', 'reps' => '4xMax', 'rest' => '90s'],
                    ['name' => 'Flexiones Spiderman', 'reps' => '4x12', 'rest' => '60s'],
                    ['name' => 'Yoga Flow (Saludo al Sol)', 'reps' => '10 vueltas', 'rest' => '60s'],
                    ['name' => 'Plancha Lateral Dinámica', 'reps' => '3x15/lado', 'rest' => '45s']
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ]
        ]);

        // 3. SAIYAN (Difficulty: HARD - Hypertrophy, Power, Limit Break)
        DB::table('trainings')->insert([
            [
                'title' => 'Saiyan: Gravedad x500 A',
                'description' => 'Entrenamiento de volumen brutal. El objetivo es romper tantas fibras como sea posible.',
                'difficulty' => 'hard',
                'exercises' => json_encode([
                    ['name' => 'Handstand Pushups (o Pica)', 'reps' => '5x8', 'rest' => '90s'],
                    ['name' => 'Pistol Squats con Salto', 'reps' => '5x5/pierna', 'rest' => '120s'],
                    ['name' => 'Muscle-Ups (o Dominadas Explosivas)', 'reps' => '4xMax', 'rest' => '120s'],
                    ['name' => 'Fondos Lastrados (o muy lentos)', 'reps' => '4x12', 'rest' => '90s'],
                    ['name' => 'Sentadillas Sissy', 'reps' => '4x15', 'rest' => '60s'],
                    ['name' => 'Gemelos Unilaterales Explosivos', 'reps' => '5x20/lado', 'rest' => '45s']
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'Saiyan: Zenkai Boost B',
                'description' => 'Protocolo de fallo muscular absoluto. Si puedes caminar después, no lo hiciste bien.',
                'difficulty' => 'hard',
                'exercises' => json_encode([
                    ['name' => 'Complex: Flexión -> Burpee -> Salto', 'reps' => '5x10', 'rest' => '90s'],
                    ['name' => 'Dominadas en L', 'reps' => '4xMax', 'rest' => '90s'],
                    ['name' => 'Zancadas con Salto (Jumping Lunges)', 'reps' => '4x30s (AMRAP)', 'rest' => '60s'],
                    ['name' => 'Flexiones Arqueras', 'reps' => '4x10/lado', 'rest' => '90s'],
                    ['name' => 'Toes to Bar (o V-Ups)', 'reps' => '5x15', 'rest' => '60s'],
                    ['name' => 'Sprints en Cuesta (o Escaleras)', 'reps' => '10x20s', 'rest' => '60s']
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ]
        ]);

        // 4. FROST (Difficulty: HARD/MEDIUM - Speed, HIIT, Cardio) -> Mapped to Hard for intensity
        DB::table('trainings')->insert([
            [
                'title' => 'Frost: Emperador del Espacio A',
                'description' => 'Velocidad pura y explosividad. Diseñado para moverse más rápido de lo que el ojo ve.',
                'difficulty' => 'hard',
                'exercises' => json_encode([
                    ['name' => 'Plyometric Pushups (Clap)', 'reps' => '6x6 (Explosivas)', 'rest' => '60s'],
                    ['name' => 'Box Jumps (Altura Máxima)', 'reps' => '5x5', 'rest' => '90s'],
                    ['name' => 'Mountain Climbers (Doble velocidad)', 'reps' => '5x45s', 'rest' => '45s'],
                    ['name' => 'Skater Jumps', 'reps' => '4x20', 'rest' => '45s'],
                    ['name' => 'Sprints Tabata (20s on / 10s off)', 'reps' => '8 Rondas', 'rest' => '2 min final'],
                    ['name' => 'Shadow Boxing (Con pesas si hay)', 'reps' => '3x3 min', 'rest' => '60s']
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'Frost: Supervivencia Final B',
                'description' => 'Resistencia anaeróbica. Mantener la intensidad máxima durante periodos prolongados.',
                'difficulty' => 'hard',
                'exercises' => json_encode([
                    ['name' => 'Burpee Box Jump Over', 'reps' => '5x10', 'rest' => '90s'],
                    ['name' => 'Shuttle Runs (Suicidios)', 'reps' => '6x20m', 'rest' => '60s'],
                    ['name' => 'Flexiones Spiderman Dinámicas', 'reps' => '4x16', 'rest' => '60s'],
                    ['name' => 'Salto a la Comba (Doble Salto)', 'reps' => '5x50', 'rest' => '45s'],
                    ['name' => 'Battle Ropes (o aleteo explosivo)', 'reps' => '4x30s', 'rest' => '45s'],
                    ['name' => 'Isométrico Sentadilla (Pared)', 'reps' => '3xMax', 'rest' => '60s']
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ]
        ]);
    }
}
