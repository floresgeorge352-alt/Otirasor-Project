<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accommodation;

class TestAccommodationSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================
        // REMOVE OLD TEST COTTAGES
        // =========================================

        Accommodation::where(
            'type',
            'Cottage'
        )
        ->where(
            'name',
            'like',
            'Test Cottage %'
        )
        ->delete();


        // =========================================
        // CREATE 50 TEST COTTAGES
        // =========================================

        // -----------------------------------------
        // COTTAGE 1 - 25
        // CAPACITY: 15 PERSONS
        // -----------------------------------------

        for ($i = 1; $i <= 25; $i++) {

            Accommodation::create([

                'name' =>
                    'Test Cottage ' . $i,

                'type' =>
                    'Cottage',

                'description' =>
                    'Cottage good for up to 15 persons.',

                'price' =>
                    1500,

                'capacity' =>
                    15,

                'image' =>
                    null,

                'status' =>
                    'available',
            ]);
        }


        // -----------------------------------------
        // COTTAGE 26 - 50
        // CAPACITY: 20 PERSONS
        // -----------------------------------------

        for ($i = 26; $i <= 50; $i++) {

            Accommodation::create([

                'name' =>
                    'Test Cottage ' . $i,

                'type' =>
                    'Cottage',

                'description' =>
                    'Cottage good for up to 20 persons.',

                'price' =>
                    2000,

                'capacity' =>
                    20,

                'image' =>
                    null,

                'status' =>
                    'available',
            ]);
        }


        // =========================================
        // TEST FUNCTION HALLS
        // =========================================

        for ($i = 1; $i <= 15; $i++) {

            Accommodation::create([

                'name' =>
                    'Test Function Hall ' . $i,

                'type' =>
                    'Function Hall',

                'description' =>
                    'Test function hall for pagination and search testing.',

                'price' =>
                    5000,

                'capacity' =>
                    50,

                'image' =>
                    null,

                'status' =>
                    'available',
            ]);
        }
    }
}