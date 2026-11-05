<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agendamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'agendamentos';

    public const STATUS = ['agendado', 'concluido', 'cancelado'];

    protected $fillable = [
        'id_pet',
        'id_servico',
        'data_hora',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'data_hora' => 'datetime',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'id_pet');
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'id_servico');
    }
}
