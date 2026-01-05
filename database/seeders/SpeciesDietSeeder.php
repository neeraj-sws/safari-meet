<?php

namespace Database\Seeders;

use App\Models\{Species, SpeciesDetailsCharactersticModel, SpeciesLifestyleModel};
use Illuminate\Database\Seeder;

class SpeciesDietSeeder extends Seeder
{
    public function run()
    {
        $speciesList = Species::all();

        foreach ($speciesList as $species) {

            if (SpeciesLifestyleModel::where('species_id', $species->id)->exists()) {
                continue;
            }

            $characterDetail = SpeciesDetailsCharactersticModel::where('species_id', $species->id)
                ->where('species_characterstics', 2)
                ->first();

            if (!$characterDetail) {
                continue;
            }

            $this->createSpeciesDiet($species->id, $characterDetail->id);
        }
    }

    public function createSpeciesDiet($speciesID, $chatId)
    {
        SpeciesLifestyleModel::create([
            'species_id' => $speciesID,
            'species_details_characterstics_id' => $chatId,
            'diet_short_description' => $this->commonDescription(),
            'habitatt_short_description' => $this->commonDescription(),
        ]);
    }

    public function commonDescription()
    {
        return "
        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit tortor risus tellus natoque nascetur, ullamcorper porta lobortis luctus habitant diam sed leo turpis sociis hendrerit mi, vehicula felis scelerisque blandit egestas augue consequat cursus pulvinar eros mollis.</p>

        <p>Class per platea porta lacinia purus eu enim laoreet suscipit sodales felis, auctor ultrices netus volutpat blandit imperdiet fermentum augue mus montes. Dui tortor pulvinar tempor magnis congue fermentum feugiat inceptos vulputate.</p>

        <p>Non cursus feugiat commodo tristique est eros primis pretium, cum blandit lacus scelerisque vehicula nascetur torquent nam suscipit, sagittis volutpat posuere augue ut netus egestas.</p>
        ";
    }
}
