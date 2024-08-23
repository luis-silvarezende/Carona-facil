<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'carona_id', 'passageiro_id', 'status', 'vagas',
    ];

    public function carona()
    {
        return $this->belongsTo(Carona::class);
    }

    public function passageiro()
    {
        return $this->belongsTo(Passageiro::class);
    }


}

