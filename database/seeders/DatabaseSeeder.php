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
        $games = \App\Models\Game::factory(rand(23, 65))->create();
        $events = \App\Models\Event::factory(rand(100, 180))->create();



        // TODO: delete this
        // ItemFactory:
            $items = \App\Models\Item::factory(rand(10, 20))->create();
        // CommentFactory:
            $comments = \App\Models\Comment::factory(rand(40, 50))->create();
        // LabelFactory:
            $labels = \App\Models\Label::factory(rand(9, 10))->create();
        // Connections:

        $comments->each(function ($comment) use (&$users, &$items) {
            // Szerző hozzáadása
            $comment
                ->author()
                ->associate($users->random())
                ->save();

            // Kommentelt item hozzárendelése
            $comment
                ->item()
                ->associate($items->random())
                ->save();
        });

        $items->each(function ($item) use (&$labels) {
            // Item-Label pivot kapcsolat hozzáadása

            if(rand(1, 10) > 3) {
                $item
                ->labels()
                ->sync($labels->random(rand(1, $labels->count())));
            }
        });
    }
}
