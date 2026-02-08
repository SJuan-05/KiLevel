<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_mission', function (Blueprint $table) {
            $table->json('exercises_progress')->nullable()->after('training_id');
        });
    }

    public function down(): void
    {
        Schema::table('user_mission', function (Blueprint $table) {
            $table->dropColumn('exercises_progress');
        });
    }
};
