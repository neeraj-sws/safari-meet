<?php

namespace Database\Seeders;

use App\Models\Park;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParkSeoSeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();

        foreach ($parks as $park) {

            if (!empty($park->meta_title) || !empty($park->meta_description)) {
                continue;
            }

            $metaTitle = $this->generateMetaTitle($park->name);
            $metaDescription = $this->generateMetaDescription($park->name);

            $park->update([
                'meta_title'       => $metaTitle,
                'meta_description' => $metaDescription,
            ]);
        }
    }

    private function generateMetaTitle($parkName)
    {
        return substr("{$parkName} - Wildlife Safari, Best Time To Visit & Travel Guide", 0, 100);
    }

    private function generateMetaDescription($parkName)
    {
        return substr(
            "$parkName is one of the most popular national parks in India, known for its rich wildlife,
            lush landscapes, and breathtaking safari experiences. Learn about safari timings, how to
            reach, best time to visit, and important travel information before planning your trip.",
            0,
            500
        );
    }
}
