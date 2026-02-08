<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'leader_id',
    ];

    // Relación con el Líder (Un usuario)
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    // Relación con los Miembros (Muchos usuarios)
    public function members()
    {
        return $this->hasMany(User::class, 'faction_id');
    }

    // Propiedad calculada: Poder Total de la Facción (Suma de niveles de miembros)
    public function getTotalPowerAttribute()
    {
        return $this->members->sum('xp'); 
    }
}
