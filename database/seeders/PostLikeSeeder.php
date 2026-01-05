<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostLike;

class PostLikeSeeder extends Seeder
{
    public function run(): void
    {
        $userCount = \App\Models\User::count();
        $postCount = \App\Models\MediaPost::count();

        if ($userCount === 0 || $postCount === 0) {
            $this->command->warn('⚠️ Users or MediaPosts table is empty. Seed them first.');
            return;
        }
        PostLike::factory()->count(5000)->create();

        $this->command->info('✅ 500 random post likes added successfully!');
    }
}
