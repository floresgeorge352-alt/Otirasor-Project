<?php

namespace Database\Seeders;

use App\Models\Fee;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['name' => 'Entrance Fee - Adult', 'type' => 'entrance', 'applies_to' => 'adult', 'amount' => 50.00],
            ['name' => 'Entrance Fee - Child', 'type' => 'entrance', 'applies_to' => 'child', 'amount' => 25.00],
            ['name' => 'Swimming Fee - Adult', 'type' => 'swimming', 'applies_to' => 'adult', 'amount' => 100.00],
            ['name' => 'Swimming Fee - Child', 'type' => 'swimming', 'applies_to' => 'child', 'amount' => 50.00],
        ];

        foreach ($defaults as $row) {
            Fee::firstOrCreate(
                ['name' => $row['name']],
                $row + ['is_active' => true]
            );
        }
    }
}