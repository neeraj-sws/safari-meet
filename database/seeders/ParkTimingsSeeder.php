<?php

namespace Database\Seeders;

use App\Models\{
    Park,
    WeatherModel,
    ParkSafariTime,
    ParkSafariTimeDetail
};
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ParkTimingsSeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();
        $weathers = WeatherModel::where('status', true)->get();

        foreach ($parks as $park) {

            if (ParkSafariTime::where('park_id', $park->id)->exists()) {
                continue;
            }

            $this->createTimings($park, $weathers);
        }
    }

    public function createTimings($park, $weathers)
    {
        foreach ($weathers as $weather) {

            $start = Carbon::create(null, $weather->start, 1)->format('F');
            $end   = Carbon::create(null, $weather->end, 1)->format('F');

            $parkTime = ParkSafariTime::create([
                'park_id'   => $park->id,
                'weather_id'=> $weather->id,
                'start'     => $start,
                'end'       => $end,
            ]);

            for ($month = 1; $month <= 12; $month++) {

                $morningTime = rand(5, 8) . ":00 AM";
                $eveningTime = rand(3, 6) . ":00 PM";

                ParkSafariTimeDetail::create([
                    'park_safari_time_id' => $parkTime->id,
                    'month'      => $month,
                    'slot_type'  => "Morning",
                    'start_time' => $morningTime,
                ]);

                ParkSafariTimeDetail::create([
                    'park_safari_time_id' => $parkTime->id,
                    'month'      => $month,
                    'slot_type'  => "Evening",
                    'start_time' => $eveningTime,
                ]);
            }
        }
    }
}
