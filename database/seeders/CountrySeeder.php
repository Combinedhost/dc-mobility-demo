<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();
        Country::insert([
                [
                    'name' => 'india',
                    'code' => 'IN'
                ],
                [
                    'name' => 'usa',
                    'code' => 'us'
                ],
            ]
        );
    }
}
