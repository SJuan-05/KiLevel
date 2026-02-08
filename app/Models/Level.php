<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_number', // 1,2,3,...
        'xp_required',  // xp total (o acumulado) requerido para ese nivel
    ];

    protected $casts = [
        'level_number' => 'integer',
        'xp_required' => 'integer',
    ];

    /**
     * Retorna el Level que corresponde a una cantidad de xp (el nivel más alto
     * cuyo xp_required <= xp).
     */
    public static function levelForXp(int $xp): ?Level
    {
        return self::where('xp_required', '<=', $xp)
            ->orderByDesc('xp_required')
            ->first();
    }

    /**
     * Nivel siguiente (por level_number) o null si no existe.
     */
    public function next(): ?Level
    {
        return self::where('level_number', $this->level_number + 1)->first();
    }
}
