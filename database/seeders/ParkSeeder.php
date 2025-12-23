<?php

namespace Database\Seeders;

use App\Models\Park;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\ParkBestTimeModel;
use App\Models\ParkSafariType;
use App\Models\ParkWildlifeFoundModel;
use App\Models\SafariType;
use App\Models\Species;
use App\Models\WeatherModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParkSeeder extends Seeder
{
    public function run()
    {
        $parks = [
            ["park" => "Khangchendzonga National Park", "country" => "India", "state" => "Sikkim", "city" => "Yuksom"],
            ["park" => "Guru Ghasidas (Sanjay) National Park", "country" => "India", "state" => "Chhattisgarh", "city" => "Ambikapur"],
            ["park" => "Indravati National Park", "country" => "India", "state" => "Chhattisgarh", "city" => "Bijapur"],
            ["park" => "Kanger Valley National Park", "country" => "India", "state" => "Chhattisgarh", "city" => "Jagdalpur"],
            ["park" => "Blackbuck National Park", "country" => "India", "state" => "Gujarat", "city" => "Bhavnagar"],
            ["park" => "Gir National Park", "country" => "India", "state" => "Gujarat", "city" => "Junagadh"],
            ["park" => "Marine National Park", "country" => "India", "state" => "Gujarat", "city" => "Jamnagar"],
            ["park" => "Vansda National Park", "country" => "India", "state" => "Gujarat", "city" => "Navsari"],
            ["park" => "Hemis National Park", "country" => "India", "state" => "Ladakh", "city" => "Leh"],
            ["park" => "Kishtwar National Park", "country" => "India", "state" => "Jammu & Kashmir", "city" => "Kishtwar"],
            ["park" => "Dachigam National Park", "country" => "India", "state" => "Jammu & Kashmir", "city" => "Srinagar"],
            ["park" => "City Forest National Park", "country" => "India", "state" => "Jammu & Kashmir", "city" => "Srinagar"],
            ["park" => "Betla National Park", "country" => "India", "state" => "Jharkhand", "city" => "Medininagar"],
            ["park" => "Palamau National Park", "country" => "India", "state" => "Jharkhand", "city" => "Medininagar"],
            ["park" => "Bandipur National Park", "country" => "India", "state" => "Karnataka", "city" => "Bandipur"],
            ["park" => "Bannerghatta National Park", "country" => "India", "state" => "Karnataka", "city" => "Bengaluru"],
            ["park" => "Kudremukh National Park", "country" => "India", "state" => "Karnataka", "city" => "Chikkamagaluru"],
            ["park" => "Nagarhole National Park", "country" => "India", "state" => "Karnataka", "city" => "Kodagu"],
            ["park" => "Eravikulam National Park", "country" => "India", "state" => "Kerala", "city" => "Munnar"],
            ["park" => "Silent Valley National Park", "country" => "India", "state" => "Kerala", "city" => "Palakkad"],
            ["park" => "Mathikettan Shola National Park", "country" => "India", "state" => "Kerala", "city" => "Munnar"],
            ["park" => "Pampadum Shola National Park", "country" => "India", "state" => "Kerala", "city" => "Idukki"],
            ["park" => "Periyar National Park", "country" => "India", "state" => "Kerala", "city" => "Thekkady"],
            ["park" => "Anamudi Shola National Park", "country" => "India", "state" => "Kerala", "city" => "Idukki"],
            ["park" => "Bandhavgarh National Park", "country" => "India", "state" => "Madhya Pradesh", "city" => "Umaria"],
            ["park" => "Fossil National Park", "country" => "India", "state" => "Madhya Pradesh", "city" => "Shahdol"],
            ["park" => "Indira Priyadarshini Pench National Park", "country" => "India", "state" => "Madhya Pradesh", "city" => "Seoni"],
            ["park" => "Kanha National Park", "country" => "India", "state" => "Madhya Pradesh", "city" => "Mandla"],
            ["park" => "Madhav National Park", "country" => "India", "state" => "Madhya Pradesh", "city" => "Shivpuri"],
            ["park" => "Panna National Park", "country" => "India", "state" => "Madhya Pradesh", "city" => "Panna"],
            ["park" => "Sanjay National Park", "country" => "India", "state" => "Madhya Pradesh", "city" => "Sidhi"],
            ["park" => "Satpura National Park", "country" => "India", "state" => "Madhya Pradesh", "city" => "Pachmarhi"],
            ["park" => "Van Vihar National Park", "country" => "India", "state" => "Madhya Pradesh", "city" => "Bhopal"],
            ["park" => "Pench National Park", "country" => "India", "state" => "Maharashtra", "city" => "Nagpur"],
            ["park" => "Tadoba Andhari National Park", "country" => "India", "state" => "Maharashtra", "city" => "Chandrapur"],
            ["park" => "Sanjay Gandhi National Park", "country" => "India", "state" => "Maharashtra", "city" => "Mumbai"],
            ["park" => "Navegaon National Park", "country" => "India", "state" => "Maharashtra", "city" => "Gondia"],
            ["park" => "Gugamal National Park", "country" => "India", "state" => "Maharashtra", "city" => "Amravati"],
            ["park" => "Chandoli National Park", "country" => "India", "state" => "Maharashtra", "city" => "Sangli"],
            ["park" => "Melghat National Park", "country" => "India", "state" => "Maharashtra", "city" => "Amravati"],
            ["park" => "Balphakram National Park", "country" => "India", "state" => "Meghalaya", "city" => "Baghmara"],
            ["park" => "Nokrek National Park", "country" => "India", "state" => "Meghalaya", "city" => "Tura"],
            ["park" => "Murlen National Park", "country" => "India", "state" => "Mizoram", "city" => "Champhai"],
            ["park" => "Phawngpui Blue Mountain National Park", "country" => "India", "state" => "Mizoram", "city" => "Lawngtlai"],
            ["park" => "Namdapha National Park", "country" => "India", "state" => "Arunachal Pradesh", "city" => "Miao"],
            ["park" => "Mouling National Park", "country" => "India", "state" => "Arunachal Pradesh", "city" => "Jengging"],
            ["park" => "Keibul Lamjao National Park", "country" => "India", "state" => "Manipur", "city" => "Bishnupur"],
            ["park" => "Pobitora National Park", "country" => "India", "state" => "Assam", "city" => "Morigaon"],
            ["park" => "Kaziranga National Park", "country" => "India", "state" => "Assam", "city" => "Golaghat"],
            ["park" => "Manas National Park", "country" => "India", "state" => "Assam", "city" => "Barpeta"],
            ["park" => "Nameri National Park", "country" => "India", "state" => "Assam", "city" => "Tezpur"],
            ["park" => "Rajiv Gandhi Orang National Park", "country" => "India", "state" => "Assam", "city" => "Darrang"],
            ["park" => "Dibru-Saikhowa National Park", "country" => "India", "state" => "Assam", "city" => "Tinsukia"],
            ["park" => "Balpakram National Park", "country" => "India", "state" => "Meghalaya", "city" => "Baghmara"],
            ["park" => "Intanki National Park", "country" => "India", "state" => "Nagaland", "city" => "Dimapur"],
            ["park" => "Simlipal National Park", "country" => "India", "state" => "Odisha", "city" => "Baripada"],
            ["park" => "Bhitarkanika National Park", "country" => "India", "state" => "Odisha", "city" => "Kendrapara"],
            ["park" => "Pin Valley National Park", "country" => "India", "state" => "Himachal Pradesh", "city" => "Kaza"],
            ["park" => "Inderkilla National Park", "country" => "India", "state" => "Himachal Pradesh", "city" => "Kullu"],
            ["park" => "Khirganga National Park", "country" => "India", "state" => "Himachal Pradesh", "city" => "Kullu"],
            ["park" => "Great Himalayan National Park", "country" => "India", "state" => "Himachal Pradesh", "city" => "Kullu"],
            ["park" => "Bandipur National Park", "country" => "India", "state" => "Karnataka", "city" => "Bandipur"],
            ["park" => "Ranthambore National Park", "country" => "India", "state" => "Rajasthan", "city" => "Sawai Madhopur"],
            ["park" => "Sariska National Park", "country" => "India", "state" => "Rajasthan", "city" => "Alwar"],
            ["park" => "Keoladeo National Park", "country" => "India", "state" => "Rajasthan", "city" => "Bharatpur"],
            ["park" => "Mukundra Hills National Park", "country" => "India", "state" => "Rajasthan", "city" => "Kota"],
            ["park" => "Desert National Park", "country" => "India", "state" => "Rajasthan", "city" => "Jaisalmer"],
            ["park" => "Gangotri National Park", "country" => "India", "state" => "Uttarakhand", "city" => "Uttarkashi"],
            ["park" => "Govind Pashu Vihar National Park", "country" => "India", "state" => "Uttarakhand", "city" => "Uttarkashi"],
            ["park" => "Jim Corbett National Park", "country" => "India", "state" => "Uttarakhand", "city" => "Ramnagar"],
            ["park" => "Nanda Devi National Park", "country" => "India", "state" => "Uttarakhand", "city" => "Joshimath"],
            ["park" => "Rajaji National Park", "country" => "India", "state" => "Uttarakhand", "city" => "Haridwar"],
            ["park" => "Valley of Flowers National Park", "country" => "India", "state" => "Uttarakhand", "city" => "Ghangaria"],
            ["park" => "Valmiki National Park", "country" => "India", "state" => "Bihar", "city" => "West Champaran"],
            ["park" => "Anamudi Shola National Park", "country" => "India", "state" => "Kerala", "city" => "Idukki"],
            ["park" => "Campbell Bay National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Campbell Bay"],
            ["park" => "Galathea Bay National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Galathea"],
            ["park" => "Mahatma Gandhi Marine National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Wandoor"],
            ["park" => "Middle Button Island National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Mayabunder"],
            ["park" => "Mount Harriet National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Port Blair"],
            ["park" => "North Button Island National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Rangat"],
            ["park" => "Rani Jhansi Marine National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Port Blair"],
            ["park" => "Saddle Peak National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Diglipur"],
            ["park" => "South Button Island National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Havelock"],
            ["park" => "Campbell Bay National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Great Nicobar"],
            ["park" => "Guindy National Park", "country" => "India", "state" => "Tamil Nadu", "city" => "Chennai"],
            ["park" => "Mudumalai National Park", "country" => "India", "state" => "Tamil Nadu", "city" => "Ooty"],
            ["park" => "Mukkurthi National Park", "country" => "India", "state" => "Tamil Nadu", "city" => "Ooty"],
            ["park" => "Gulf of Mannar Marine National Park", "country" => "India", "state" => "Tamil Nadu", "city" => "Rameswaram"],
            ["park" => "Saramati National Park", "country" => "India", "state" => "Nagaland", "city" => "Kiphire"],
            ["park" => "Rani Jhansi National Park", "country" => "India", "state" => "Andaman & Nicobar Islands", "city" => "Port Blair"],
        ];


        foreach ($parks as $data) {

            if (Park::where('name', $data['park'])->exists()) {
                continue;
            }

            $country = Country::firstOrCreate(
                ['name' => $data['country']],
                ['sortname' => strtoupper(Str::substr($data['country'], 0, 3)), 'phonecode' => 91]
            );

            $state = State::firstOrCreate(
                ['name' => $data['state'], 'country_id' => $country->country_id]
            );

            $city = City::firstOrCreate(
                ['name' => $data['city'], 'state_id' => $state->state_id]
            );

            $baseSlug = Str::slug($data['park']);
            $slug = $baseSlug;
            $counter = 1;
            while (Park::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }


            $park = Park::create([
                'name'             => $data['park'],
                'slug'             => $slug,
                'short_description' => "Short info about " . $data['park'],
                'description'      => $this->dummyDescription(),
                'banner_title'     => $data['park'] . " Wildlife",

                'country_id'       => $country->country_id,
                'state_id'         => $state->state_id,
                'city_id'          => $city->city_id,

                'area'             => rand(100, 2000) . " sq km",
                'established'      => rand(1950, 2020),
                'famous_for'       => "Wildlife tourism",
                'core_zone'        => "Core Zone A",
                'buffer_zone'      => "Buffer Zone B",
                'core_zone_price'  => rand(500, 1500),
                'buffer_zone_price' => rand(300, 1200),
                'entry_gates'      => "Main Gate",
                'nearest_railway'  => "Nearest Railway Station",

                'morning_time'     => "06:00 AM - 10:00 AM",
                'afternoon_time'   => "03:00 PM - 06:00 PM",
                'status'           => true,

                'display_image'    => "https://loremflickr.com/800/600/forest?rand=" . mt_rand(1000, 9999),
                'banner_image'     => "https://loremflickr.com/1600/600/wildlife?rand=" . mt_rand(1000, 9999),
            ]);

            $this->CreateSafariType($park->id);
            $this->CreateWildlife($park->id);
            $this->CreateWeather($park->id);
        }
    }

    private function CreateSafariType($parkId)
    {
        $types = SafariType::where('status', 1)->get();

        foreach ($types as $type) {
            ParkSafariType::create([
                'park_id' => $parkId,
                'safari_type_id' => $type->id,
            ]);
        }
    }

    private function CreateWildlife($parkId)
    {
        $wildlife = Species::where('status', 1)
            ->inRandomOrder()
            ->take(4)
            ->get();

        foreach ($wildlife as $item) {
            ParkWildlifeFoundModel::create([
                'park_id'    => $parkId,
                'species_id' => $item->id,
            ]);
        }
    }

    private function CreateWeather($parkId)
    {
        $months = WeatherModel::where('status', 1)->get();

        foreach ($months as $month) {
            ParkBestTimeModel::create([
                'park_id'     => $parkId,
                'weathers_id' => $month->id,
            ]);
        }
    }

    private function dummyDescription()
    {
        return "This national park is known for its rich biodiversity, scenic landscapes, and rare wildlife species.";
    }
}
