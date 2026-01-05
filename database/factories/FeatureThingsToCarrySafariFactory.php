<?php

namespace Database\Factories;

use App\Models\FeatureThingsToCarrySafari;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureThingsToCarrySafariFactory extends Factory
{
    protected $model = FeatureThingsToCarrySafari::class;

    public function definition(): array
    {
        return [
            'share_safari_id' => null, // Can be set at creation time
            'package_id' => null, // Can be set at creation time
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'status' => 1,
        ];
    }
}
