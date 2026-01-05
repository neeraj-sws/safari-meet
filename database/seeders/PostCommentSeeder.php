<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostComment;

class PostCommentSeeder extends Seeder
{
    public function run()
    {
        // Delete old data if needed (optional)
        // PostComment::truncate();

        PostComment::factory()->count(500)->create();
    }
}
