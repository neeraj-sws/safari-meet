<?php

namespace Database\Factories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureFactory extends Factory
{
    protected $model = Feature::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'icon' => $this->faker->word() . '.svg',
            'type' => $this->faker->randomElement([1, 2]), // 1 = Inclusion, 2 = Exclusion
            'status' => 1,
        ];
    }
}
