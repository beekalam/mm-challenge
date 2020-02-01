<?php

use App\Player;
use App\Team;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name'     => 'user',
            'email'    => 'user@demo.com',
            'password' => bcrypt('secret')
        ]);

        $manchester = factory(Team::class)->create([
            'name' => 'manchester'
        ]);
        $chelsea = factory(Team::class)->create([
            'name' => 'Chelsea'
        ]);

        foreach (range(1, 5) as $i) {
            $users = factory(Player::class, 2)->create();
            $manchester->players()->attach($users);
            $chelsea->players()->attach($users);
        }

        foreach (range(1, 5) as $i) {
            $users = factory(Player::class, 2)->create();
            $chelsea->players()->attach($users);
            $manchester->players()->attach($users);
        }

        $football_teams = ['FC Bayern München', 'Arsenal', 'Liverpool', 'Paris Saint-Germain', 'AS Monaco',
            'Bayer Leverkusen', 'Schalke 04', 'Juventus', 'Inter Milan', 'Benfica', 'Sporting Lisbon',
            'AFC Ajax Amsterdam', 'PSV Eindhoven'];
        $faker = Faker\Factory::create();
        foreach (range(1, 100) as $i) {
            $team = factory(Team::class)->create([
                'name' => $football_teams[array_rand($football_teams)] . '-' . $faker->unique()->numberBetween(1, 100)
            ]);
            foreach (range(1, 8) as $j) {
                $players = factory(Player::class)->create();
                $team->players()->attach($players);
            }
        }

    }
}
