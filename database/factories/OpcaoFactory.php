<?php

namespace Database\Factories;

use App\Models\Opcao;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpcaoFactory extends Factory
{
    protected $model = Opcao::class;

    public function definition()
    {
        return [
            'nome'  => $this->faker->words(3, true),
            'ordem' => $this->faker->randomDigitNotNull(),
        ];
    }
}


