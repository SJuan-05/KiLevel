<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Mission;
use App\Models\Reward;
use App\Models\Level;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password', // <--- IMPORTANT FIX
        'race',
        'raw_password',
        'plan',
        'level',
        'xp',
        'zeni', 
        'current_title',
        'unlocked_titles',
        'xp_multiplier',
        'avatar',
        'faction_id', 
        'faction_role', // <--- Ranks: leader, veteran, member
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'level' => 'integer',
        'xp' => 'integer',
        'zeni' => 'integer',
        'unlocked_titles' => 'array', // <--- Cast as array
    ];

    /**
     * Relación muchos-a-muchos con Mission (pivot user_mission, con campo 'completed').
     */
    public function missions()
    {
        return $this->belongsToMany(Mission::class, 'user_mission')
            ->withPivot('completed', 'expires_at', 'training_id', 'exercises_progress')
            ->withTimestamps();
    }

    /**
     * Devuelve la misión activa actual (si existe y no ha expirado)
     */
    public function activeMission()
    {
        return $this->belongsToMany(Mission::class, 'user_mission')
            ->where('missions.type', 'daily') 
            ->where(function($q) {
                $q->where('user_mission.expires_at', '>', now())
                  ->orWhereNull('user_mission.expires_at');
            })
            ->wherePivot('completed', false)
            ->withPivot('id', 'completed', 'expires_at', 'training_id', 'exercises_progress')
            ->orderByPivot('created_at', 'desc');
    }

    public function activePrograms()
    {
        return $this->belongsToMany(Mission::class, 'user_mission')
            ->where('missions.type', 'program') 
            ->wherePivot('completed', false)
            ->withPivot('id', 'completed', 'expires_at', 'training_id', 'exercises_progress') 
            ->orderByPivot('created_at', 'desc');
    }

    /**
     * Devuelve TODAS las misiones activas (plural) - OLD/Generic
     */
    public function activeMissions()
    {
        return $this->belongsToMany(Mission::class, 'user_mission')
            ->where(function($q) {
                $q->where('user_mission.expires_at', '>', now())
                  ->orWhereNull('user_mission.expires_at');
            })
            ->wherePivot('completed', false)
            ->withPivot('id', 'completed', 'expires_at', 'training_id', 'exercises_progress') // Include pivot ID for deletion
            ->orderByPivot('created_at', 'desc');
    }

    /**
     * Relación muchos-a-muchos con Reward (pivot user_reward).
     */
    public function rewards()
    {
        return $this->belongsToMany(Reward::class)
            ->withTimestamps();
    }

    /**
     * Añade XP al usuario y actualiza el nivel según la tabla levels.
     * @param int $amount
     */
    public function addXp(int $amount): void
    {
        $multiplier = $this->xp_multiplier ?? 1.0;
        $multipliedXp = (int) ($amount * $multiplier);
        $this->xp = ($this->xp ?? 0) + $multipliedXp;

        // Busca el nivel más alto cuyo xp_required <= xp total
        $level = Level::where('xp_required', '<=', $this->xp)
            ->orderByDesc('xp_required')
            ->first();

        if ($level && $level->level_number > ($this->level ?? 0)) {
            $this->level = $level->level_number;
        }

        $this->save();
    }

    /**
     * Devuelve el XP necesario para el siguiente nivel (o null si no hay siguiente).
     */
    public function xpToNextLevel(): ?int
    {
        $next = Level::where('level_number', ($this->level ?? 0) + 1)->first();
        if (! $next) return null;
        // Si almacenas xp acumulada total, calcular falta: next->xp_required - current xp
        return max(0, $next->xp_required - ($this->xp ?? 0));
    }

    /**
     * Porcentaje de progreso hacia el siguiente nivel (0-100).
     */
    public function xpPercent(): float
    {
        $currentLvl = Level::where('level_number', $this->level ?? 1)->first();
        $nextLvl = Level::where('level_number', ($this->level ?? 1) + 1)->first();
        
        if (!$nextLvl) return 100.0;
        
        $currentXp = $this->xp ?? 0;
        $minXp = $currentLvl ? $currentLvl->xp_required : 0;
        $maxXp = $nextLvl->xp_required;
        
        $range = $maxXp - $minXp;
        if ($range <= 0) return 0.0;
        
        $relativeXp = $currentXp - $minXp;
        $percent = ($relativeXp / $range) * 100;
        
        return (float) max(0, min(100, $percent));
    }
    /**
     * Calcula la racha de días consecutivos entrenando.
     */
    public function getStreakAttribute(): int
    {
        // 1. Obtener fechas únicas de misiones completadas (orden descendente)
        $dates = DB::table('user_mission')
            ->where('user_id', $this->id)
            ->where('completed', true)
            ->orderBy('updated_at', 'desc')
            ->pluck('updated_at')
            ->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('Y-m-d');
            })
            ->unique()
            ->values();

        if ($dates->isEmpty()) {
            return 0;
        }

        $today = \Carbon\Carbon::today()->format('Y-m-d');
        $yesterday = \Carbon\Carbon::yesterday()->format('Y-m-d');

        // 2. Si el último entrenamiento no fue ni hoy ni ayer, la racha es 0
        if ($dates[0] !== $today && $dates[0] !== $yesterday) {
            return 0;
        }

        // 3. Contar días seguidos
        $streak = 1;
        for ($i = 0; $i < $dates->count() - 1; $i++) {
            $current = \Carbon\Carbon::parse($dates[$i]);
            $next = \Carbon\Carbon::parse($dates[$i + 1]);

            // Si la diferencia es de exactamente un día, incrementamos
            if ((int) abs($current->diffInDays($next)) === 1) {
                $streak++;
            } else {
                // Si hay un hueco de más de un día, paramos
                break;
            }
        }

        return $streak;
    }
    /**
     * Calcula la ganancia de Zeni estimada para una dificultad dada,
     * teniendo en cuenta el plan del usuario.
     */
    public function calculateZeniReward(string $difficulty = 'easy'): int
    {
        $zeniMultiplier = match(strtolower($difficulty)) {
            'easy' => 1,
            'medium' => 2,
            'hard' => 3,
            'god' => 5,
            default => 1
        };
        
        $baseGain = 50 * $zeniMultiplier;

        $planMultiplier = match($this->plan) {
            'kaio' => 1.5,
            'whis' => 2,
            default => 1
        };

        return (int) ($baseGain * $planMultiplier);
    }

    /**
     * Sincroniza el multiplicador de XP basado en el plan actual.
     */
    public function syncPlanMultiplier(): void
    {
        $this->xp_multiplier = match($this->plan) {
            'whis' => 2.0,
            'kaio' => 1.5,
            default => 1.0
        };
        $this->save();
    }

    // --- SISTEMA SOCIAL & CHAT ---

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Relación con la Facción
    public function faction()
    {
        return $this->belongsTo(Faction::class);
    }

    // --- SISTEMA SOCIAL ---

    // Amigos que yo he agregado y han aceptado
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accepted')
                    ->withTimestamps();
    }

    // Amigos que me han agregado y he aceptado
    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
                    ->wherePivot('status', 'accepted')
                    ->withTimestamps();
    }

    // Relación combinada para obtener TODOS los amigos
    public function getAllFriendsAttribute()
    {
        return $this->friends->merge($this->friendOf);
    }

    // Solicitudes que he RECIBIDO y están pendientes
    public function pendingRequestsReceived()
    {
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
                    ->wherePivot('status', 'pending')
                    ->withTimestamps();
    }

    // Solicitudes que he ENVIADO y están pendientes
    public function pendingRequestsSent()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->wherePivot('status', 'pending')
                    ->withTimestamps();
    }

    /**
     * Verifica si el usuario actual es aliado de otro
     * (Mismo clan o Amigos aceptados)
     */
    public function isAllyWith($otherUser)
    {
        if (!$otherUser) return false;
        if ($this->id === $otherUser->id) return true;
        
        // Mismo Clan
        if ($this->faction_id && $this->faction_id === $otherUser->faction_id) {
            return true;
        }

        // Comprobar si son amigos
        return $this->friends()->where('friend_id', $otherUser->id)->exists() || 
               $this->friendOf()->where('user_id', $otherUser->id)->exists();
    }
}
