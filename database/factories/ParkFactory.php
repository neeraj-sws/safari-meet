<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ParkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Park::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->company();

        return [
            'name' => $name,
            'title' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(6),
            'short_description' => $this->faker->sentence(),
            'state_id' => 21,
            'country_id' => 101,
        ];
    }
}
