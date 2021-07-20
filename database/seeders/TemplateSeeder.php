<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Template::truncate();
        Template::insert([
            [
                'title' => 'Welcome',
                'code' => '<div><p>Dear {user-first-name} </p><p>Congratulations on joining DC Mobility!
        We\'re excited to have you with us.</p>
        <p>Your User ID: {user_id}</p>
        <p>We’ll send you another email with your tracking number as soon as your order has been shipped</p>
        <p>Here’s your address details:</p>
        <p>Email: {email}</p>
        <p>Phone: {phone}</p>
        <p>Address:  {address}</p>
        <p>Thanks,</p>
        <p>Team DC Mobility</p>
        </div>'
            ]
        ]);
    }
}
