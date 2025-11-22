<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        // Dummy data for Bengkulu area
        Area::create([
            'name' => 'Bengkulu City',
            'province' => 'Bengkulu',
            'coordinates' => [
                'lat' => -3.80044,
                'lng' => 102.26554,
            ],
        ]);
    }
}
