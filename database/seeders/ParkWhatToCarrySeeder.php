<?php

namespace Database\Seeders;

use App\Models\Park;
use App\Models\ParkWhatToCarryModel;
use App\Models\ThingsToCarry;
use Illuminate\Database\Seeder;

class ParkWhatToCarrySeeder extends Seeder
{
    public function run()
    {
        $parks = Park::all();
        $defaultItems = ThingsToCarry::all();

        foreach ($parks as $park) {

            $this->seedItems($park->id, $defaultItems);
        }
    }

    private function seedItems($parkId, $defaultItems)
    {
        $count = rand(8, 12);

        if ($defaultItems->count() > 0) {
            $items = $defaultItems->random(min($count, $defaultItems->count()));
            foreach ($items as $item) {
                ParkWhatToCarryModel::create([
                    'park_id'           => $parkId,
                    'heading'           => $item->title,
                    'short_description' => $item->short_description,
                    'image'             => $item->image ?? $this->randomImage(),
                ]);
            }
        }

        for ($i = $defaultItems->count(); $i < $count; $i++) {
            ParkWhatToCarryModel::create([
                'park_id'           => $parkId,
                'heading'           => $this->fakeHeading(),
                'short_description' => $this->fakeDescription(),
                'image'             => $this->randomImage(),
            ]);
        }
    }

    private function randomImage()
    {
        return "https://loremflickr.com/400/300/travel?rand=" . mt_rand(1000, 99999);
    }

    private function fakeHeading()
    {
        $headings = [
            "Carry Enough Water",
            "Wear Comfortable Shoes",
            "Carry Binoculars",
            "Keep a First Aid Kit",
            "Carry Power Bank",
            "Carry Warm Clothing",
            "Use Sunscreen",
            "Carry Insect Repellent",
            "Bring Identity Proof",
            "Carry Rain Gear",
        ];
        return $headings[array_rand($headings)];
    }

    private function fakeDescription()
    {
        return "Make sure you keep this item with you during your trip for better comfort and safety.";
    }
}
