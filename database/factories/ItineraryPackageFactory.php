<?php

namespace Database\Factories;

use App\Models\ItineraryPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItineraryPackageFactory extends Factory
{
    protected $model = ItineraryPackage::class;

    public function definition(): array
    {
        return [
            'share_safari_id' => null, // Can be set at creation time
            'package_id' => null, // Can be set at creation time
            'order_by' => $this->faker->numberBetween(1, 10),
            'short_description' => $this->faker->sentence(),
        ];
    }
}
