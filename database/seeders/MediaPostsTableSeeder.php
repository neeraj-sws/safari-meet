<?php

namespace Database\Seeders;

use App\Models\MediaPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MediaPost::factory()->count(100)->create();

        $this->command->info('✅ 100 fake media posts inserted!');
    }
}
