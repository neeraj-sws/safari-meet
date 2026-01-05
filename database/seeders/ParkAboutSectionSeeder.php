<?php

namespace Database\Seeders;

use App\Models\{Park, ParkAboutSection};
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParkAboutSectionSeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();

        foreach ($parks as $park) {

            if (ParkAboutSection::where('park_id', $park->id)->exists()) {
                continue;
            }

            $this->createAboutSection($park->id);
        }
    }

    public function createAboutSection($parkId)
    {
        $faker = fake();

        for ($i = 1; $i <= 10; $i++) {

            ParkAboutSection::create([
                'park_id' => $parkId,
                'title'   => ucfirst($faker->words(3, true)),
                'image'   => "https://loremflickr.com/600/800/forest?rand=" . mt_rand(10000, 99999),
                'short_description' => $this->dummyDescription(),
            ]);
        }
    }

    private function dummyDescription()
    {
        return "
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vel magna vel felis pulvinar vehicula.</p>
        <p>Aliquam erat volutpat. Pellentesque pellentesque nunc non orci consectetur, ut varius lorem sodales.</p>
        <p>Etiam sed velit id neque tempor pharetra. Integer vel bibendum odio. Aenean eu augue a nisi luctus gravida.</p>
        ";
    }
}
