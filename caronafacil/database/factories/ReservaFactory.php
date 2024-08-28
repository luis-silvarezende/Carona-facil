<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\Carona;
use App\Models\Passageiro;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition()
    {
        return [
            'carona_id' => Carona::factory(),
            'passageiro_id' => Passageiro::factory(),
            'status' => $this->faker->randomElement(['pendente', 'aceita', 'rejeitada']),
            'vagas' => $this->faker->numberBetween(1, 4),
        ];
    }
}
