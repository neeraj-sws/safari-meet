<?php

namespace Database\Seeders;

use App\Models\Species;
use App\Models\SpeciesDetailsCharactersticModel;
use App\Models\SpeciesPhysicalAppereancesModel;
use Illuminate\Database\Seeder;

class SpeciesPhysicalAppereancesSeeder extends Seeder
{
    public function run()
    {
        $speciesList = Species::all();

        foreach ($speciesList as $species) {

            if (SpeciesPhysicalAppereancesModel::where('species_id', $species->id)->exists()) {
                continue;
            }

            $characterDetail = SpeciesDetailsCharactersticModel::where('species_id', $species->id)
                ->where('species_characterstics', 2)
                ->first();

            if (!$characterDetail) {
                continue;
            }

            $this->createSpeciesPhysicalAppereances($species->id, $characterDetail->id);
        }
    }

    public function createSpeciesPhysicalAppereances($speciesId, $characterDetailID)
    {
        $description = $this->commonDescription();

        SpeciesPhysicalAppereancesModel::create([
            'species_id'                         => $speciesId,
            'species_details_characterstics_id'  => $characterDetailID,
            'adaptation_description'             => $description,
            'appearance_description'             => $description,
            'trait'                              => $this->TraitData(),
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

    public function TraitData()
    {
        $traits = [
            "Length" => [
                "Male"   => "1.6 to 2.0 m",
                "Female" => "1.6 to 2.0 m"
            ],
            "Weight" => [
                "Male"   => "30–75 kg",
                "Female" => "25–45 kg"
            ],
            "Height" => [
                "Male"   => "90–95 cm",
                "Female" => "70–90 cm"
            ]
        ];

        return json_encode($traits);
    }
}
