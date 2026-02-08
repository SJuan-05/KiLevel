<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'xp_reward',   // xp que da la misión
        'difficulty',  // easy|medium|hard
        'difficulty',  // easy|medium|hard
        'active',      // boolean
        'type',        // 'daily', 'program'
    ];

    protected $casts = [
        'xp_reward' => 'integer',
        'active' => 'boolean',
    ];

    /**
     * Usuarios que han aceptado/completado la misión (pivot user_mission).
     * Pivot contiene: completed (boolean), created_at, updated_at
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_mission')
            ->withPivot('completed', 'training_id', 'exercises_progress')
            ->withTimestamps();
    }

    /**
     * Scope para misiones activas
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
    
    public function scopeDaily($query)
    {
        return $query->where('type', 'daily');
    }

    public function scopeProgram($query)
    {
        return $query->where('type', 'program');
    }
}
