<?php

use App\Type;
use App\User;
use App\Settings;
use App\Team;
use App\Ticket;
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
        // $this->call(UsersTableSeeder::class);
        factory(User::class)->create([
            'email'    => 'admin@handesk.io',
            'password' => bcrypt('admin'),
            'admin'    => true,
        ]);

        Settings::create();

        factory(Type::class)->create([
            'name'    => 'Trouble',
        ]);
        for ($i=0; $i < 10; $i++) {
            factory(User::class)->create();
        }
        for ($i=0; $i < 50; $i++) {
            factory(Ticket::class)->create();
        }

        $teams = factory(Team::class, 5)->create();
        $teams->each(function ($team) {
            $team->memberships()->create([
                "user_id" => factory(User::class)->create()->id
            ]);
            $team->tickets()->createMany(factory(Ticket::class, 4)->make()->toArray());
        });
    }
}
