<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\User::create([
            'name' => 'test1',
            'email' => 'test1@gmail.com',
            "password" => 'test1234'
        ]);
        \App\Models\User::create([
            'name' => 'test2',
            'email' => 'test2@gmail.com',
            "password" => 'test1234'
        ]);
    }
}
