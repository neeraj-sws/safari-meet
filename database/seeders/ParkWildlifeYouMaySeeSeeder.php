<?php

namespace Database\Seeders;

use App\Models\{
    Park,
    ParkSpecies,
    Species
};
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ParkWildlifeYouMaySeeSeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();
        $species = Species::where('status', true)->inRandomOrder()->take(50)->get();

        foreach ($parks as $park) {

            $this->createParkWildlifeYouMaySee($park, $species);
        }
    }

    public function createParkWildlifeYouMaySee($park, $species)
    {
        foreach ($species as $specie) {

            ParkSpecies::create([
                'park_id' => $park->id,
                'species_id' => $specie->id,
            ]);
        }
    }
}
