<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ['gól', "öngól", "sárga lap", "piros lap"];
        return [
            "type" => $types[array_rand($types,1)],
            "minute" => rand(0, 110),
        ];
    }
}
