<?php

use App\Settings;
use App\Team;
use App\Ticket;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@handesk.io',
            'password' => bcrypt('admin'),
            'admin'    => true,
        ]);

        Settings::create();
    }
}
