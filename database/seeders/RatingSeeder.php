<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Rating::create([
            'rating' => 8,
            'rated_by_user_id' => 2,
            'user_id' => 1
        ]);
        \App\Models\Rating::create([
            'rating' => 8,
            'rated_by_user_id' => 1,
            'user_id' => 2
        ]);
    }
}
