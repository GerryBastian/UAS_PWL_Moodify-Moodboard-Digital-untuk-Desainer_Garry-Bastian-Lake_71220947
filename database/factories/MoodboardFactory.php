<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Moodboard>
 */
class MoodboardFactory extends Factory
{
    public function definition(): array
    {
        static $index = 1; // Supaya kode MD_001, MD_002, dst
        $themes = ['Minimalist', 'Retro', 'Modern', 'Nature', 'Futuristic', 'Dreamy'];

        return [
            'code' => 'MD_' . str_pad($index++, 3, '0', STR_PAD_LEFT),
            'title' => ucfirst($this->faker->word()) . ' Moodboard',
            'description' => $this->faker->sentence(10),
            'theme' => $this->faker->randomElement($themes),
            'creator' => $this->faker->name(),
            'color1' => $this->faker->hexColor(),
            'color2' => $this->faker->hexColor(),
            'color3' => $this->faker->hexColor(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
