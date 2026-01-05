<?php

namespace Database\Seeders;

use App\Models\AlbumCategory;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumTagCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dummy Tags
        $tags = ['Wildlife', 'Adventure', 'Nature', 'Family', 'Travel', 'Jungle', 'Safari', 'Sunset', 'Mountains'];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag]);
        }

        // Dummy Categories
        $categories = ['Wildlife Tour', 'Vacation', 'Family Trip', 'Adventure Trail', 'Photography Session'];

        foreach ($categories as $category) {
            AlbumCategory::firstOrCreate(['name' => $category]);
        }
    }
}
