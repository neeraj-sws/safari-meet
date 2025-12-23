<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\MediaPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostLikeFactory extends Factory
{
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $post = MediaPost::inRandomOrder()->first();

        return [
            'user_id' => $user ? $user->id : 1,
            'post_id' => $post ? $post->id : 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
