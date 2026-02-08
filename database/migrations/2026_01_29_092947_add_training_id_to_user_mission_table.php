<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_mission', function (Blueprint $table) {
            $table->foreignId('training_id')->nullable()->after('mission_id')->constrained('trainings')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('user_mission', function (Blueprint $table) {
            $table->dropForeign(['training_id']);
            $table->dropColumn('training_id');
        });
    }
};
