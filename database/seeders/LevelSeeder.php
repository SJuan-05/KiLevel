<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Generates levels 1 to 100 with a progressive XP curve.
     */
    public function run(): void
    {
        $levels = [];
        $baseXp = 1000;
        $now = Carbon::now();

        // Level 1 starts at 0 XP
        $levels[] = [
            'level_number' => 1,
            'xp_required' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // Formula: xp_required = Previous_XP + (BaseXP * LevelMultiplier)
        // Simple linear/exponential curve could work. Let's do a simple progressive curve.
        // Level 2 req: 1000
        // Level 3 req: 2200 (1000 + 1200)
        // ...
        
        $currentXp = 0;
        
        for ($i = 2; $i <= 100; $i++) {
            // Amount needed to reach this level from previous level
            $gap = $baseXp * ($i - 1) * 0.5 + $baseXp; 
            // Simplified: Level 2 needs 1000 total. Level 3 needs 2500 total...
            // Let's stick to a simpler standard RPG curve:
            // XP = (Level^2) * 100 (Too easy?)
            // XP = (Level * 1000) (Linear?)
            
            // Let's use: Total XP for Level L = 500 * (L^2 - L) / 2 isn't quite right for big numbers.
            // Let's use: Next Level = Current Level * 1000 + delta
            
            // Implementation choice:
            // Level 2: 1000
            // Level 3: 2250
            // Level 4: 3750
            // ...
            
            $reqForNext = (int) (1000 * pow($i-1, 1.2)); 
            
            $levels[] = [
                'level_number' => $i,
                'xp_required' => $reqForNext,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('levels')->insert($levels);
    }
}
