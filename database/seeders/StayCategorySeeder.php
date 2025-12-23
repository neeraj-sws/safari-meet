<?php

namespace Database\Seeders;

use App\Models\StayCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StayCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         StayCategory::insert([
            ['name' => 'Premium', 'description' => ''],
            ['name' => 'Standard', 'description' => ''],
            ['name' => 'Economical', 'description' => ''],
            ['name' => 'Not Included', 'description' => ''],
        ]);
    }
}
