<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Package::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->unique()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(6),
            'park_id' => \App\Models\Park::factory(),
            'min_price_pp' => $this->faker->numberBetween(50, 500),
            'max_price_pp' => $this->faker->numberBetween(501, 2000),
            'display_image' => null,
            'stay_category_id' => $this->faker->numberBetween(1, 3),
            'status' => 1,
            'no_of_safari' => $this->faker->numberBetween(1,5),
        ];
    }
}
