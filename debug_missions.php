<?php

use App\Models\Mission;
use Illuminate\Support\Facades\Schema;

// 1. Check if table exists
echo "Table 'missions' exists: " . (Schema::hasTable('missions') ? 'YES' : 'NO') . "\n";

// 2. Count missions
$count = Mission::count();
echo "Total Missions: $count\n";

// 3. Count active missions
$activeCount = Mission::where('active', true)->count();
echo "Active Missions (raw query): $activeCount\n";

// 4. Test scope
$scopeCount = Mission::active()->count();
echo "Active Missions (scope): $scopeCount\n";

// 5. List all missions
$missions = Mission::all();
foreach ($missions as $mission) {
    echo "[$mission->id] $mission->title (Active: $mission->active)\n";
}
