<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Campos para el Plan y Gamificación
            $table->string('plan')->default('Roshi'); // Roshi, Kaio, Whis
            $table->float('xp_multiplier')->default(1.0); // 1.0, 1.5, 2.0
            $table->integer('streak')->default(0);
            $table->string('current_title')->default('Aprendiz Tortuga');
            $table->date('last_training_at')->nullable();
        });
    }
};
