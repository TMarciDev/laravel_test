<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users_count = rand(5, 10);
        $users = collect();
        $users->add(
            \App\Models\User::factory()->create([
                "email" => "admin@szerveroldali.hu",
                "name" => "ADMIN USER",
                "is_admin" => true,
                "password" => bcrypt('adminpwd'),
            ])
        );
        for ($i = 1; $i <= $users_count; $i++) {
            $users->add(
                \App\Models\User::factory()->create([
                    "email" => "user" . $i . "@szerveroldali.hu",
                ])
            );
        }

        $teams = \App\Models\Team::factory(rand(10, 20))->create();
        $players = \App\Models\Player::factory(rand(200, 300))->create();
        $games = \App\Models\Game::factory(rand(100, 120))->create();
        $events = \App\Models\Event::factory(rand(400, 500))->create();

        $players->each(function ($player) use (&$teams) {
            $player
                ->team()
                ->associate($teams->random())
                ->save();
        });

        $games->each(function ($game) use (&$teams) {
            $home_team = $teams->random();
            $away_team = $teams->random();
            while ($home_team == $away_team) {
                $away_team = $teams->random();
            }

            $game
                ->homeTeam()
                ->associate($home_team)
                ->save();
            $game
                ->awayTeam()
                ->associate($away_team)
                ->save();
        });

        $events->each(function ($event) use (&$games, &$players) {
            $randomGame = $games->random();
            $randomHomePlayer = $randomGame->HomeTeam->Players->random();
            $randomAwayPlayer = $randomGame->AwayTeam->Players->random();
            $event
                ->game()
                ->associate($randomGame)
                ->save();
            $event
                ->player()
                ->associate(rand(0, 1) == 1 ? $randomHomePlayer : $randomAwayPlayer)
                ->save();

        });

        $users->each(function ($user) use (&$teams) {
            if(rand(1, 10) > 3) {
                $user
                ->teams()
                ->sync($teams->random(rand(1, $teams->count())));
            }
        });
    }
}
