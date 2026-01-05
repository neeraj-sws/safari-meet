<?php

namespace Database\Seeders;

use App\Models\{User, Admin};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'user@gmail.com',
        // ]);

        // Admin::factory()->create([
        //     'name' => 'Test Admin',
        //     'email' => 'admin@gmail.com',
        // ]);

        // $this->call(WildlifeSeeder::class);
        $this->call([
            AlbumTagCategorySeeder::class,
        ]);
    }
}
