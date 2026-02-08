<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('xp_reward');
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
};
