<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    private static $emailIncrement = 1;
    private static $phoneIncrement = 7000000000;

    public function definition()
    {
        static $cityIds = null;

        if ($cityIds === null) {
            $cityIds = City::where('state_id', 21)->pluck('city_id')->toArray();

            if (empty($cityIds)) {
                // Ensure location records exist for factory defaults
                $country = \App\Models\Country::firstOrCreate(
                    ['country_id' => 101],
                    ['sortname' => 'IN', 'name' => 'India', 'phonecode' => '91']
                );

                $state = \App\Models\State::firstOrCreate(
                    ['state_id' => 21],
                    ['country_id' => $country->country_id, 'name' => 'Default State']
                );

                $city = City::firstOrCreate(
                    ['state_id' => $state->state_id, 'name' => 'Default City']
                );

                $cityIds = [$city->city_id];
            }
        }

        $cityId = $cityIds[array_rand($cityIds)];

        $emailNumber = self::$emailIncrement++;
        $phone = self::$phoneIncrement++;

        return [
            'name' => $this->faker->name,
            'username' => Str::slug($this->faker->userName . $emailNumber),
            'email' => $this->faker->name . "{$emailNumber}@yopmail.com",
            'phone_number' => (string) (7000000000 + self::$emailIncrement),
            'password' => '$2y$12$qNn7q81AczZ.YkVqsYk9TObsiI1F5pyV22tJ5X8efpW1kHiVfKdp.',

            'country_id' => 101,
            'state_id' => 21,
            'city_id' => $cityId,

            'user_type' => 0,
            'status' => 1,
        ];
    }


    public function normal()
    {
        return $this->state([
            'user_type' => 0,
        ]);
    }

    public function agent()
    {
        return $this->state(function () {
            return [
                'user_type' => 1,
                'agency_name' => $this->faker->company,
                'contact_person' => $this->faker->name,
                'license_number' => strtoupper(Str::random(10)),
                'website_url' => $this->faker->url,
                'experience_year' => rand(1, 20),
            ];
        });
    }
}
