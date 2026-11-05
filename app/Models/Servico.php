<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servico extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'duracao_minutos',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'duracao_minutos' => 'integer',
    ];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'id_servico');
    }
}
