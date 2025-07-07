<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //    make benefits
        $benefits = [
            'ID Card',
            'Stickers',
            'Greeting Card',
            'Lanyard',
            'Gantungan Kunci',
            'Card Tag',
            'Exclusive Box',
            'Hand Bag',
            'T-Shirt',
            'Hoodie',
        ];
        foreach ($benefits as $benefit) {

            DB::table('benefits')->insert([
                'name' => $benefit,
            ]);
        }
    }
}
