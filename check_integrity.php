<?php

use App\Models\User;
use App\Models\Training;
use Illuminate\Support\Facades\DB;

$orphans = DB::table('user_mission')
    ->whereNotNull('training_id')
    ->whereNotExists(function ($query) {
        $query->select(DB::raw(1))
              ->from('trainings')
              ->whereRaw('trainings.id = user_mission.training_id');
    })
    ->count();

echo "Orphaned Training IDs found: $orphans\n";

if ($orphans > 0) {
    echo "Fixing orphans...\n";
    DB::table('user_mission')
        ->whereNotNull('training_id')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('trainings')
                  ->whereRaw('trainings.id = user_mission.training_id');
        })
        ->update(['training_id' => null]);
    echo "Orphans set to NULL.\n";
} else {
    echo "Database integrity is perfect.\n";
}
