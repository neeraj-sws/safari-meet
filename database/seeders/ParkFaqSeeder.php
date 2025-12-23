<?php

namespace Database\Seeders;

use App\Models\Park;
use App\Models\ParkFaq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParkFaqSeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();

        foreach ($parks as $park) {

            // if (ParkFaq::where('park_id', $park->id)->exists()) {
            //     continue;
            // }

            $this->createFaqForPark($park->id);
        }
    }

    private function createFaqForPark($parkId)
    {
        $questions = [
            "What is the best time to visit this park?",
            "Are safari rides available throughout the year?",
            "How can I book safari tickets?",
            "Is photography allowed inside the park?",
            "Are private vehicles permitted?",
            "What wildlife species can be seen here?",
            "Are accommodation facilities available near the park?",
            "How many safari zones are there?",
            "Is a guide mandatory for safari?",
            "What are the park opening and closing timings?",
            "Can senior citizens join the safari?",
            "What should I carry during a visit?",
            "Are food and drinks allowed inside?",
            "Is the park safe for children?",
            "Is parking available at the entry gate?",
            "Do online safari bookings get confirmed instantly?",
            "Is this park suitable for bird watching?",
            "How far is the nearest airport?",
            "Is medical assistance available nearby?",
            "What are the rules and regulations inside the park?",
            "Are night safaris offered?",
            "How many days are enough to explore the park?",
            "Does the park have restrooms inside?",
            "Are drone cameras allowed?",
            "Can we hire private jeeps for safari?"
        ];

        for ($i = 0; $i < 25; $i++) {
            ParkFaq::create([
                'park_id'   => $parkId,
                'question'  => $questions[$i],
                'answer'    => $this->fakeAnswer(),
            ]);
        }
    }

    private function fakeAnswer()
    {
        return "This information may vary depending on weather, park regulations,
                and seasonal conditions. Visitors are advised to check the official
                park guidelines or contact the help desk before planning their trip.";
    }
}
