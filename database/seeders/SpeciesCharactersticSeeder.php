<?php

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;
use App\Models\SpeciesCharacterstic;
use App\Models\SpeciesDetailsCharactersticModel;

class SpeciesCharactersticSeeder extends Seeder
{
    public function run()
    {
        $species_Data = Species::get();
        foreach ($species_Data as $species) {
            $characterDetailsData = SpeciesDetailsCharactersticModel::where('species_id', $species->id)->exists();
            if ($characterDetailsData) {
                continue;
            } else {

                $this->createSpeciesCharacterstic($species->id);
            }
        }
    }

    public function createSpeciesCharacterstic($speciesID)
    {
        $characterstics = SpeciesCharacterstic::where('status', 1)->get();
        foreach ($characterstics as $characterstic) {
             SpeciesDetailsCharactersticModel::create([
                'species_characterstics' => $characterstic->id,
                'species_id' => $speciesID,
                'title' => $characterstic->title,
                'status' => true,
            ]);
        }
    }
}
