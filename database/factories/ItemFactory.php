<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => rtrim(fake()->sentence(), "."),
            "description" => fake()->paragraphs(rand(2,8), true),
            "obtained" => fake()->date('Y_m_d H:i:s'),
            "image" => null,
        ];
    }
}
