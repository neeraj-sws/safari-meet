<?php

namespace Database\Factories;

use App\Models\ThingsToCarry;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThingsToCarryFactory extends Factory
{
    protected $model = ThingsToCarry::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'status' => 1,
        ];
    }
}
