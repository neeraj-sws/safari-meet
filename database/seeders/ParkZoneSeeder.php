<?php

namespace Database\Seeders;

use App\Models\{Park, ParkZoneModel};
use Illuminate\Database\Seeder;

class ParkZoneSeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();

        foreach ($parks as $park) {

            if (ParkZoneModel::where('park_id', $park->id)->exists()) {
                continue;
            }

            $this->createZone($park->id);
        }
    }

    public function createZone($parkId)
    {
        $faker = fake();

        for ($i = 1; $i <= 100; $i++) {

            ParkZoneModel::create([
                'park_id'    => $parkId,
                'type'       => $faker->randomElement([1, 2]),
                'zone_name'  => $faker->words(3, true),
                'entry_gate' => $faker->words(3, true),
            ]);
        }
    }
}
