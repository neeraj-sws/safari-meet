<?php

namespace Database\Seeders;

use App\Models\{AdaptationModel, Species, SpeciesDetailsCharactersticModel};
use Illuminate\Database\Seeder;

class SpeciesAdaptationsSeeder extends Seeder
{
    public function run()
    {
        $speciesList = Species::all();

        foreach ($speciesList as $species) {

            if (AdaptationModel::where('species_id', $species->id)->exists()) {
                continue;
            }

            $this->createSpeciesAdaptations($species->id);
        }
    }

    public function createSpeciesAdaptations($speciesId)
    {
        for ($i = 1; $i <= 5; $i++) {
            AdaptationModel::create([
                'species_id' => $speciesId,
                'title' => $this->commonTitle(),
                'short_description' => $this->commonDescription(),
            ]);
        }
    }

    public function commonDescription()
    {
        return "
        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit tortor risus tellus natoque nascetur, ullamcorper porta lobortis luctus habitant diam sed leo turpis sociis hendrerit mi, vehicula felis scelerisque blandit egestas augue consequat cursus pulvinar eros mollis.</p>

        <p>Class per platea porta lacinia purus eu enim laoreet suscipit sodales felis, auctor ultrices netus volutpat blandit imperdiet fermentum augue mus montes. Dui tortor pulvinar tempor magnis congue fermentum feugiat inceptos vulputate.</p>

        <p>Non cursus feugiat commodo tristique est eros primis pretium, cum blandit lacus scelerisque vehicula nascetur torquent nam suscipit, sagittis volutpat posuere augue ut netus egestas.</p>
        ";
    }

    public function commonTitle(){
        return "Lorem ipsum dolor sit amet consectetur adipiscing";
    }
}
