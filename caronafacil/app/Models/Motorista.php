<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Motorista extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nome', 'email', 'password', 'telefone', 'cnh',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}

