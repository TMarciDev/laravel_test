<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $time = fake()->dateTimeBetween('-1 week', '+1 week');
        $strTime = strtotime($time->format('Y-m-d h:m:s'));
        return [
            "start" => $time,
            "finished" => !($strTime > time() - 20000),
        ];
    }
}
