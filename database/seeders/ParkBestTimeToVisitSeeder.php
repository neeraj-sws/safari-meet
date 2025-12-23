<?php

namespace Database\Seeders;

use App\Models\Park;
use App\Models\ParkBestTimeVistModel;
use Illuminate\Database\Seeder;

class ParkBestTimeToVisitSeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();

        foreach ($parks as $park) {

            if (ParkBestTimeVistModel::where('park_id', $park->id)->exists()) {
                continue;
            }

            $this->seedBestTime($park->id);
        }
    }

    private function seedBestTime($parkId)
    {
        $headings = [
            "Best Season for Wildlife Sightings",
            "Ideal Time for Safari Experience",
            "Perfect Weather for a Comfortable Visit",
            "Best Time for Photography Enthusiasts",
            "Peak Tourist Season Insights",
            "Least Crowded Months",
            "When the Climate Is Most Pleasant",
            "Top Months to Explore the Park",
            "Seasonal Highlights",
            "Best Time for Nature Walks",
        ];

        for ($i = 0; $i < 5; $i++) {
            ParkBestTimeVistModel::create([
                'park_id'     => $parkId,
                'heading'     => $headings[array_rand($headings)],
                'description' => $this->fakeDescription(),
            ]);
        }
    }

    private function fakeDescription()
    {
        return "<p>The weather during this period is ideal for exploring the park, offering great visibility and
                comfortable temperatures. Wildlife sightings increase significantly, making it one of the most
                recommended times to visit.</p>";
    }
}
