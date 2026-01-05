<?php

namespace Database\Seeders;

use App\Models\Park;
use App\Models\ParkTraveltipsModel;
use Illuminate\Database\Seeder;

class ParkTravelTipsSeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();

        foreach ($parks as $park) {

            ParkTraveltipsModel::create([
                'park_id' => $park->id,
                'weather' => $this->weatherHtml($park->name),
                'safetyTips' => $this->weatherHtml($park->name),
            ]);
        }
    }

    private function weatherHtml($parkName)
    {
        return "
            <h3>Weather Overview of {$parkName}</h3>
            <p>{$parkName} experiences diverse weather conditions throughout the year,
            making it important for visitors to plan their trip accordingly.</p>

            <h4>Summer (March – June)</h4>
            <p>The temperatures can rise significantly during the daytime, but mornings and evenings remain pleasant.
            Ideal for wildlife spotting as many animals visit water bodies.</p>

            <h4>Monsoon (July – September)</h4>
            <p>The region receives moderate to heavy rainfall. The forest becomes lush green,
            but accessibility may be limited due to seasonal closures.</p>

            <h4>Winter (October – February)</h4>
            <p>Winters are cool and comfortable. This is one of the best times to visit the park,
            with clear skies and higher chances of spotting wildlife.</p>

            <p><strong>Travel Tip:</strong> Always check the local weather forecast before planning your visit.</p>
        ";
    }
}
