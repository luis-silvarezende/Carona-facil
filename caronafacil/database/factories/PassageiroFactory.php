<?php

namespace Database\Factories;

use App\Models\Passageiro;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PassageiroFactory extends Factory
{
    protected $model = Passageiro::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // senha padrão para testes
            'telefone' => $this->faker->phoneNumber,
        ];
    }
}
