<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carona extends Model
{
    use HasFactory;

    protected $fillable = [
        'origem', 'destino', 'data_hora', 'valor', 'motorista_id', 'veiculo', 'placa', 'vagas'
    ];
    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}

