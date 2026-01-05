<?php

namespace Database\Factories;

use App\Models\PostComment;
use App\Models\User;
use App\Models\MediaPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostCommentFactory extends Factory
{
    protected $model = PostComment::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->value('user_id') ?? 1,
            'post_id' => MediaPost::inRandomOrder()->value('id') ?? 1,
            'comment' => $this->faker->sentence(rand(5, 12)),
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'updated_at' => now(),
        ];
    }
}
