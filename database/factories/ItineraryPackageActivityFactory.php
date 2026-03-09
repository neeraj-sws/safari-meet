<?php

namespace Database\Factories;

use App\Models\ItineraryPackageActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItineraryPackageActivityFactory extends Factory
{
    protected $model = ItineraryPackageActivity::class;

    public function definition(): array
    {
        return [
            'itinerary_packages_id' => \App\Models\ItineraryPackage::factory(),
            'safari_itinerary_activities_id' => null,
            'activity' => $this->faker->sentence(),
        ];
    }
}
