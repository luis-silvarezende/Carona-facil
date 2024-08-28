<?php

namespace Database\Factories;

use App\Models\Carona;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CaronaFactory extends Factory
{
    protected $model = Carona::class;

    public function definition()
    {
        return [
            'origem' => $this->faker->city,
            'destino' => $this->faker->city,
            'data_hora' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'valor' => $this->faker->randomFloat(2, 0, 100),
            'vagas' => $this->faker->numberBetween(1, 5),
            'veiculo' => $this->faker->word,
            'placa' => strtoupper($this->faker->bothify('???-####')),
            'motorista_id' => \App\Models\Motorista::factory(), // Cria um motorista automaticamente
        ];
    }
}
