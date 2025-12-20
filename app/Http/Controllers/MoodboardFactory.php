<?php

namespace Database\Factories;

use App\Models\Moodboard;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoodboardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Moodboard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => 'MD-' . $this->faker->unique()->randomNumber(6),
            'title' => $this->faker->bs,
            'description' => $this->faker->paragraph(3),
            'theme' => $this->faker->randomElement(['minimalist', 'retro', 'dreamy', 'modern', 'nature']),
            'creator' => $this->faker->name,
            'color_key_1' => $this->faker->hexColor,
            'color_key_2' => $this->faker->hexColor,
            'color_key_3' => $this->faker->hexColor,
            'image_path' => null, // Anda bisa menggantinya dengan path gambar default jika ada
        ];
    }
}