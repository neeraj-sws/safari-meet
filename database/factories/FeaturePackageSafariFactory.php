<?php

namespace Database\Factories;

use App\Models\FeaturePackageSafari;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeaturePackageSafariFactory extends Factory
{
    protected $model = FeaturePackageSafari::class;

    public function definition(): array
    {
        return [
            'share_safari_id' => null, // Can be set at creation time
            'package_id' => null, // Can be set at creation time
            'type' => $this->faker->randomElement([1, 2]),
            'icon' => $this->faker->word() . '.svg',
            'title' => $this->faker->sentence(2),
            'status' => 1,
        ];
    }
}
