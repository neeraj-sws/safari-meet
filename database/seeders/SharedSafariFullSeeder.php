<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    ShareSafari,
    Park,
    ParkSafariType,
    VisitPurpose,
    StayCategory,
    SafariesType,
    User
};
use Illuminate\Support\Str;

class SharedSafariFullSeeder extends Seeder
{
    public function run()
    {
        $users         = User::all();
        $parks         = Park::where('status', 1)->get();
        $visitPurposes = VisitPurpose::pluck('visit_purpose_id')->toArray();
        $stayCats      = StayCategory::pluck('stay_category_id')->toArray();

        foreach ($users as $user) {
            $this->createShsaredSafari($user, $parks, $visitPurposes, $stayCats);
        }
    }

    public function createShsaredSafari($user, $parks, $visitPurposes, $stayCats)
    {
        for ($i = 1; $i <= 10; $i++) {

            $park = $parks->random();

            $parkSafariTypes = ParkSafariType::where('park_id', $park->id)
                ->pluck('safari_type_id')
                ->toArray();

            if (empty($parkSafariTypes)) continue;

            $title = ucfirst($user['user_type']) . " Safari " . Str::random(5);
            $baseSlug = Str::slug($title);
            $slug = $baseSlug;
            $counter = 1;

            while (ShareSafari::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $startDate = fake()->dateTimeBetween('+10 days', '+60 days')->format('Y-m-d');
            $endDate   = fake()->dateTimeBetween('+61 days', '+120 days')->format('Y-m-d');

            $min = rand(5000, 60000);
            $max = $min;

            $totalSeats = rand(5, 12);
            $shareSeats = rand(1, floor($totalSeats / 2));

            $safari = ShareSafari::create([
                'uuid' => Str::uuid(),

                'title' => $title,
                'slug'  => $slug,
                'status' => 1,

                'safari_park_id' => $park->id,

                'day' => $startDate,
                'night' => $endDate,
                'no_of_safari' => rand(3, 15),

                'visit_purpose_id' => $visitPurposes[array_rand($visitPurposes)],
                'stay_category_id' => $stayCats[array_rand($stayCats)],

                'min_price_pp' => $min,
                'max_price_pp' => $max,

                'total_seats' => $totalSeats,
                'share_seats' => $shareSeats,

                'is_create_safari_complete' => 'completed',

                'display_image' => "https://loremflickr.com/800/600/safari?rand=" . rand(1000, 9999),

                'category_id' => null,

                'best_month_start' => rand(1, 6),
                'best_month_end'   => rand(7, 12),

                'organized_by'   => $user['id'],
                'organized_type' => $user['user_type'] == 1 ? 'agent' : 'user',

                'popular' => rand(0, 1),
                'trending' => rand(0, 1),
                'top_rated' => rand(0, 1),

                'ip_address' => fake()->ipv6(),
                'browser' => "Chrome 142.0.0.0",
                'os' => "Windows 10.0",
                'device' => "Desktop",

                'is_approved' => 1,
            ]);

            $randomTypes = fake()->randomElements($parkSafariTypes, rand(1, count($parkSafariTypes)));

            foreach ($randomTypes as $type) {
                SafariesType::create([
                    'shared_safari_id' => $safari->shared_safari_id,
                    'safari_type_id'   => $type,
                ]);
            }
        }
    }
}
