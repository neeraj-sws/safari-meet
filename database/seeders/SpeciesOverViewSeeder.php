<?php

namespace Database\Seeders;

use App\Models\Species;
use App\Models\SpeciesCategory;
use App\Models\SpeciesFamilyModel;
use App\Models\SpeciesGenusModel;
use App\Models\SpeciesOverviewModel;
use App\Models\SpeciesDetailsCharactersticModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpeciesOverViewSeeder extends Seeder
{
    public function run()
    {
        $speciesList = Species::all();

        foreach ($speciesList as $species) {

            if (SpeciesOverviewModel::where('species_id', $species->id)->exists()) {
                continue;
            }
            $characterDetail = SpeciesDetailsCharactersticModel::where('species_id', $species->id)
                ->where('species_characterstics', 1)
                ->first();

            if (!$characterDetail) {
                continue;
            }

            $this->createSpeciesOverView($species->id, $characterDetail->id);
        }
    }

    public function createSpeciesOverView($speciesID, $characterDetailID)
    {
        $bannerUrl = "https://loremflickr.com/1600/600/animal?rand=" . mt_rand(10000, 99999);

        $category = SpeciesCategory::where('status', 1)->inRandomOrder()->first();
        $family = SpeciesFamilyModel::where('category_id', $category->id)
            ->where('status', 1)
            ->inRandomOrder()
            ->first();
        if (!$family) {
            $family = $this->createSpeciesFamily($category->id);
        }
        $genus = SpeciesGenusModel::where('species_family_id', $family->id)
            ->where('status', 1)
            ->inRandomOrder()
            ->first();

        if (!$genus) {
            $genus = $this->createSpeciesGenus($category->id, $family->id);
        }

        SpeciesOverviewModel::create([
            'species_id'                        => $speciesID,
            'species_details_characterstics_id' => $characterDetailID,

            'species_category_id' => $category->id,
            'species_family_id'   => $family->id,
            'species_genus_id'    => $genus->id,

            'about'       => $this->dummyDescription(),
            'about_image' => $bannerUrl,

            'life_span' => $this->fakeLifeSpan(),
            'speed'     => $this->fakeSpeed(),
            'mass'      => $this->fakeMass(),
            'height'    => $this->fakeHeight(),
            'length'    => $this->fakeLength(),
        ]);
    }

    public function createSpeciesFamily($categoryId)
    {
        return SpeciesFamilyModel::create([
            'category_id' => $categoryId,
            'name'        => "Family " . Str::random(6),
            'status'      => 1,
        ]);
    }

    public function createSpeciesGenus($categoryId, $familyID)
    {
        return SpeciesGenusModel::create([
            'category_id'       => $categoryId,
            'species_family_id' => $familyID,
            'name'              => "Genus " . Str::random(6),
            'status'            => 1,
        ]);
    }


    private function fakeLifeSpan()
    {
        $min = rand(5, 30);
        $max = $min + rand(3, 12);
        return "{$min}-{$max} years";
    }

    private function fakeSpeed()
    {
        return rand(5, 120) . " km/h";
    }

    private function fakeMass()
    {
        return rand(1, 800) . " kg";
    }

    private function fakeHeight()
    {
        return rand(30, 250) . " cm";
    }

    private function fakeLength()
    {
        return rand(40, 300) . " cm";
    }

    private function dummyDescription()
    {
        return "<p>Lorem ipsum dolor sit amet consectetur adipiscing elit tortor risus tellus natoque nascetur, ullamcorper porta lobortis luctus habitant diam sed leo turpis sociis hendrerit mi, vehicula felis scelerisque blandit egestas augue consequat cursus pulvinar eros mollis. Posuere ullamcorper sagittis facilisi phasellus dictumst nulla primis suspendisse faucibus ultrices, fusce tincidunt molestie volutpat litora pulvinar ultricies porttitor ut proin, curabitur rutrum nascetur convallis himenaeos aliquam et curae fermentum. Per felis neque venenatis aliquet primis etiam nibh, senectus litora posuere vel sagittis cras auctor cum, leo dictumst molestie morbi nullam lectus. Eros dui habitant molestie sapien penatibus sollicitudin tempus ad purus nulla, consequat cras varius scelerisque fusce tincidunt cum aptent. Convallis pharetra justo dignissim senectus urna luctus ad placerat quam cubilia erat tortor ultrices, torquent id metus vitae mattis suscipit commodo velit tristique cum eros.</p>
<p>Class per platea porta lacinia purus eu enim laoreet suscipit sodales felis, auctor ultrices netus volutpat blandit imperdiet fermentum augue mus montes. Dui tortor pulvinar tempor magnis congue fermentum feugiat inceptos vulputate, a praesent vestibulum posuere est et facilisi scelerisque, quam ad felis rutrum pretium tincidunt fusce proin.</p>
<p>Non cursus feugiat commodo tristique est eros primis pretium, cum blandit lacus scelerisque vehicula nascetur torquent nam suscipit, sagittis volutpat posuere augue ut netus egestas. Feugiat accumsan sollicitudin lacinia inceptos habitasse montes condimentum sodales himenaeos, etiam donec nostra mus at natoque tortor sagittis. Augue auctor facilisi quam natoque taciti venenatis mus, nam nullam primis nisi cum parturient, magna ante euismod interdum class orci. Volutpat placerat quis lectus purus dictum himenaeos quam tempor sed, consequat mus metus molestie egestas blandit donec at, pulvinar ultricies dis integer fusce sem platea porttitor. Dis aenean dictumst id penatibus hac massa varius natoque, proin pharetra arcu eget mattis fusce ullamcorper mus, phasellus orci consequat per enim duis cubilia. Aptent scelerisque erat quam nisi ornare purus sociis commodo, fringilla parturient fames cubilia netus inceptos suspendisse sollicitudin nibh, vivamus rutrum venenatis ultricies convallis magna eget.</p>";
    }
}
