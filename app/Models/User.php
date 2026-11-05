<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'id_dono',
        'last_login',
    ];

    protected $hidden = [
        'password',
    ];

    public function dono()
    {
        return $this->belongsTo(Dono::class, 'id_dono');
    }
}
