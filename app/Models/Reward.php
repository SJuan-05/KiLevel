<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',       // e.g. 'item','aura','badge'
        'xp_required', // xp mínimo para desbloquear (opcional)
        'icon',       // ruta o nombre de icono
    ];

    protected $casts = [
        'xp_required' => 'integer',
    ];

    /**
     * Usuarios que poseen esta recompensa (pivot user_reward).
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }

    /**
     * Comprueba si un usuario cumple el requisito de XP para obtener la reward.
     */
    public function isUnlockedBy(User $user): bool
    {
        if (is_null($this->xp_required)) return true;
        return ($user->xp ?? 0) >= $this->xp_required;
    }
}
