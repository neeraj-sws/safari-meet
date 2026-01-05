<?php

namespace Database\Seeders;

use App\Models\Park;
use App\Models\ReachabilityMode;
use App\Models\ParkReachability;
use Illuminate\Database\Seeder;

class ParkReachabilitySeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();
        $reachModes = ReachabilityMode::where('status', true)->get();

        foreach ($parks as $park) {

            foreach ($reachModes as $mode) {

                $exists = ParkReachability::where('park_id', $park->id)
                    ->where('reachability_id', $mode->reachability_modes_id)
                    ->exists();

                if ($exists) {
                    continue;
                }

                ParkReachability::create([
                    'park_id'         => $park->id,
                    'reachability_id' => $mode->reachability_modes_id,
                    'title'           => $mode->title,
                    'description'     => $this->dummyDescription(),
                ]);
            }
        }
    }

    private function dummyDescription()
    {
        return "<p>This reachability option provides easy access to the park through well-maintained routes.</p>
                <p>Transportation facilities are available frequently and ensure a smooth journey for visitors.</p>";
    }
}
