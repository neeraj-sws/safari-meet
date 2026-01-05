<?php

namespace Database\Seeders;

use App\Models\{Park, ParkDetailsTabs, ParkTabs};
use Illuminate\Database\Seeder;

class ParkTabsSeeder extends Seeder
{
    public function run()
    {
        $parkLists = Park::all();

        foreach ($parkLists as $parkList) {

            if (ParkDetailsTabs::where('park_id', $parkList->id)->exists()) {
                continue;
            }

            $this->createParkTabs($parkList->id);
        }
    }

    public function createParkTabs($parkId)
    {
        $characterstics = ParkTabs::where('status', 1)->get();
        foreach ($characterstics as $characterstic) {
            ParkDetailsTabs::create([
                'park_tabs_id' => $characterstic->id,
                'park_id' => $parkId,
                'title' => $characterstic->title,
                'status' => true,
            ]);
        }
    }
}
