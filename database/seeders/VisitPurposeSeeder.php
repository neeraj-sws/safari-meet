<?php

namespace Database\Seeders;

use App\Models\VisitPurpose;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisitPurpose::insert([
            ['name' => 'Photography', 'description' => 'Wildlife or nature photography.'],
            ['name' => 'Safari Experience', 'description' => 'Guided safari tour.'],
            ['name' => 'Educational Visit', 'description' => 'For school or research purposes.'],
            ['name' => 'Wildlife Observation', 'description' => 'Personal exploration and sightseeing.'],
        ]);
    }
}
