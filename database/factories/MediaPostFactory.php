<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Park;

class MediaPostFactory extends Factory
{
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $park = Park::inRandomOrder()->first();

        $videos = [
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerJoyrides.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerMeltdowns.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/SubaruOutbackOnStreetAndDirt.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/WeAreGoingOnBullrun.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/WhatCarCanYouGetForAGrand.mp4',
        ];

        $images = [
            'https://picsum.photos/800/600?random=' . mt_rand(1000, 9999),
            'https://loremflickr.com/800/600/wildlife?rand=' . mt_rand(1000, 9999),
        ];

        $type = $this->faker->randomElement(['image', 'video']);

        $mediaUrl = $type === 'video'
            ? $this->faker->randomElement($videos)
            : $this->faker->randomElement($images);

        return [
            'user_id'    => $user ? $user->id : 1,
            'user_type'  => 'user',
            'media_url'  => $mediaUrl,
            'caption'    => $this->faker->sentence(),
            'type'       => $type,
            'visibility' => 'public',
            'park_id'    => $park ? $park->id : null,
        ];
    }
}
