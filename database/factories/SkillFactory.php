<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition(): array
    {
        return [
            'owner_id' => (string) $this->faker->uuid(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(1000, 20000),
            'category' => $this->faker->randomElement(['Programming', 'Design', 'Language']),
            'area' => $this->faker->randomElement(['Tokyo', 'Kanagawa', 'Chiba']),
            'image_url' => null,
        ];
    }
}