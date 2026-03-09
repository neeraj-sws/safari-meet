<?php

namespace Database\Factories;

use App\Models\ShareSafari;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShareSafariFactory extends Factory
{
    protected $model = ShareSafari::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTimeBetween('+1 day', '+30 days'),
            'destination' => $this->faker->city(),
            'safari_park_id' => \App\Models\Park::factory(),
            'created_by' => \App\Models\User::factory(),
            'status' => 1,
        ];
    }
}
