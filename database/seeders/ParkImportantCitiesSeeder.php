<?php

namespace Database\Seeders;

use App\Models\Park;
use App\Models\City;
use App\Models\ReachabilityMode;
use App\Models\ParkReachability;
use App\Models\ParkReachabilityDistance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParkImportantCitiesSeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();
        $reachModes = ReachabilityMode::where('status', true)->get();

        foreach ($parks as $park) {

            $reachabilityMap = [];

            foreach ($reachModes as $mode) {

                $slug = Str::slug($mode->title);

                $exist = ParkReachability::where('park_id', $park->id)
                    ->where('reachability_id', $mode->reachability_modes_id)
                    ->first();

                if (!$exist) {
                    $exist = ParkReachability::create([
                        'park_id'        => $park->id,
                        'reachability_id' => $mode->reachability_modes_id,
                        'title'          => $mode->title,
                        'heading'        => $mode->title . " Reachability",
                    ]);
                }else{
                    $exist->title = $mode->title;
                    $exist->heading = $mode->title . " Reachability";
                    $exist->display_image = "https://loremflickr.com/1600/600/animal?rand=" . mt_rand(10000, 99999);
                    $exist->save();
                }

                $reachabilityMap[$slug] = $exist->id;
            }

            $cities = City::where('state_id', $park->state_id)
                ->inRandomOrder()
                ->take(30)
                ->get();


            if ($cities->count() < 30) {
                $moreCities = City::inRandomOrder()
                    ->take(30 - $cities->count())
                    ->get();

                $cities = $cities->merge($moreCities);
            }

            foreach ($cities as $city) {

                foreach ($reachModes as $mode) {

                    $slug = Str::slug($mode->title);

                    ParkReachabilityDistance::create([
                        'park_id'         => $park->id,
                        'city_id'         => $city->city_id,
                        'reachability_id' => $reachabilityMap[$slug] ?? null,
                        'distance'        => $this->randomDistance(),
                    ]);
                }
            }
        }
    }

    private function randomDistance()
    {
        $km = rand(5, 1500);
        return $km . " km";
    }
}
