<?php

namespace Database\Seeders;

use App\Models\{DietModel, Species};
use Illuminate\Database\Seeder;

class SpeciesDietDetailsSeeder extends Seeder
{
    public function run()
    {
        $speciesList = Species::all();

        foreach ($speciesList as $species) {

            if (DietModel::where('species_id', $species->id)->exists()) {
                continue;
            }

            $this->createSpeciesDietDetails($species->id);
        }
    }

    public function createSpeciesDietDetails($speciesId)
    {
        $bannerUrl = "https://loremflickr.com/1600/600/animal?rand=" . mt_rand(10000, 99999);

        for ($i = 1; $i <= 3; $i++) {
            DietModel::create([
                'species_id' => $speciesId,
                'title' => $this->commonTitle(),
                'image' => $bannerUrl,
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

    public function commonTitle()
    {
        return "Lorem ipsum dolor sit amet consectetur adipiscing";
    }
}
