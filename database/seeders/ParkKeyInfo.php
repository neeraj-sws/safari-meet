<?php

namespace Database\Seeders;

use App\Models\{Park, ParkDetailsTabs, ParkKeyInfoModel};
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParkKeyInfo extends Seeder
{
    public function run()
    {
        $parkLists = Park::all();

        foreach ($parkLists as $parkList) {

            if (ParkKeyInfoModel::where('park_id', $parkList->id)->exists()) {
                continue;
            }

            $this->createParkKeyInfo($parkList->id);
        }
    }

    public function createParkKeyInfo($parkId)
    {
        $imageUrl = "https://loremflickr.com/1600/600/animal?rand=" . mt_rand(10000, 99999);
        ParkKeyInfoModel::create([
            'park_id' => $parkId,
            'overview_image' => $imageUrl,
            'travel_info_image' => $imageUrl,
            'timing_cost_image' => $imageUrl,
        ]);
    }
}
