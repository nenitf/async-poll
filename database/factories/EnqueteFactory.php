<?php

namespace Database\Factories;

use App\Models\Enquete;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnqueteFactory extends Factory
{
    protected $model = Enquete::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->words(3, true)
        ];
    }
}

