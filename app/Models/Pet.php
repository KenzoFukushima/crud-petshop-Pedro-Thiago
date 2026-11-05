<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_dono',
        'nome',
        'especie',
        'raça',
        'peso',
        'idade',
    ];

    public function dono()
    {
        return $this->belongsTo(Dono::class, 'id_dono');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'id_pet');
    }
}
