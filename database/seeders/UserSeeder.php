<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(1000)->normal()->create();
        User::factory()->count(500)->agent()->create();
    }
}
