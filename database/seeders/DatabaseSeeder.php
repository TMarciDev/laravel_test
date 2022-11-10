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
        // user1@szerveroldali.hu
        // user2@...
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

        // ItemFactory:
            $items = \App\Models\Item::factory(rand(10, 20))->create();
        // CommentFactory:
            $comments = \App\Models\Comment::factory(rand(40, 50))->create();
        // LabelFactory:
            //TODO: 2 way connections
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
