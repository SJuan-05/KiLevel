<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Mission;
use App\Models\User;
use App\Models\Training;

try {
    // Check Program Missions
    echo "Checking Programs:\n";
    $programs = Mission::where('type', 'program')->get();
    echo "Found " . $programs->count() . " Program Missions.\n";
    foreach($programs as $p) {
        echo "[{$p->id}] {$p->title}\n";
    }

    // Check Logic simulation
    $race = 'saiyan';
    $m = Mission::program()->where('title', 'like', '%CLASE ' . strtoupper($race) . '%')->first();
    echo "Simulation Search for 'saiyan': " . ($m ? "Found ID {$m->id}" : "NOT FOUND") . "\n";
    $firstTraining = Training::first();
    if ($firstTraining) {
        echo "First Training Exercises Type: " . gettype($firstTraining->exercises) . "\n";
        echo "Exercises Count: " . (is_array($firstTraining->exercises) ? count($firstTraining->exercises) : 'Not an array') . "\n";
    }
    echo "Levels count: " . App\Models\Level::count() . "\n";
    echo "Active Missions count: " . Mission::where('active', true)->count() . "\n";
    $user = User::latest()->first();
    if ($user) {
        echo "User: " . $user->email . "\n";
        $pivot = DB::table('user_mission')->where('user_id', $user->id)->get();
        echo "User Missions Pivot:\n";
        foreach($pivot as $p) {
            echo " - ID: {$p->id} | Mission: {$p->mission_id} | Completed: {$p->completed} | Updated: {$p->updated_at} | Expires: {$p->expires_at}\n";
        }
    } else {
        echo "No users found.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
