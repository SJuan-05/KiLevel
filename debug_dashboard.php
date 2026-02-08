<?php
$user = \App\Models\User::where('name', 'like', 'Aaron%')->first();
echo "User ID: " . $user->id . "\n";

$allActive = $user->activeMissions()->get();
echo "Total Active Missions: " . $allActive->count() . "\n";

foreach ($allActive as $m) {
    echo "Mission: " . $m->title . " | Expires: " . $m->pivot->expires_at . "\n";
    $exp = \Carbon\Carbon::parse($m->pivot->expires_at);
    $diff = $exp->diffInDays(now());
    echo "DiffInDays: " . $diff . "\n";
    $isTraining = $diff > 365;
    echo "Is Training (>365): " . ($isTraining ? 'YES' : 'NO') . "\n";
    echo "------------------------\n";
}
