<?php

namespace Database\Factories;

use App\Enums\SkillCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(1000, 20000),
            'category' => $this->faker->randomElement(array_map(
                static fn (SkillCategory $category): string => $category->value,
                SkillCategory::cases(),
            )),
            'area' => $this->faker->randomElement(['Tokyo', 'Kanagawa', 'Chiba']),
            'image_url' => null,
        ];
    }
}
