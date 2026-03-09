<?php

namespace Database\Factories;

use App\Models\ParkFaq;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParkFaqFactory extends Factory
{
    protected $model = ParkFaq::class;

    public function definition(): array
    {
        return [
            'park_id' => \App\Models\Park::factory(),
            'question' => $this->faker->sentence() . '?',
            'answer' => $this->faker->paragraph(),
        ];
    }
}
