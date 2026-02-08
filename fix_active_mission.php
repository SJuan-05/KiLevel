<?php

use App\Models\User;
use App\Models\Training;
use Illuminate\Support\Facades\Auth;

$user = User::find(5); // Assuming user ID 5 based on previous logs
if ($user) {
    $mission = $user->activeMission()->first();
    if ($mission) {
        echo "Active Mission: {$mission->title}\n";
        echo "Pivot Training ID: " . ($mission->pivot->training_id ?? 'NULL') . "\n";
        
        if (!$mission->pivot->training_id) {
            echo "Fixing missing training_id...\n";
            $training = Training::where('difficulty', $mission->difficulty)->inRandomOrder()->first();
            if ($training) {
                // Update pivot
                $user->missions()->updateExistingPivot($mission->id, ['training_id' => $training->id]);
                echo "Assigned Training: {$training->title} (ID: {$training->id})\n";
            }
        }
    } else {
        echo "No active mission found.\n";
    }
} else {
    echo "User 5 not found.\n";
}
