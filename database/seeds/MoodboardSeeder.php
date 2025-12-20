<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MoodboardSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();
        $themes = ['Minimalist', 'Retro', 'Modern', 'Nature', 'Futuristic', 'Dreamy'];

        for ($i = 1; $i <= 10; $i++) {
            DB::table('moodboards')->insert([
                'code' => 'MD_' . str_pad($i, 3, '0', STR_PAD_LEFT), // Format MD_001
                'title' => ucfirst($faker->word()) . ' Moodboard',
                'description' => $faker->sentence(10),
                'theme' => $faker->randomElement($themes),
                'creator' => $faker->name(),
                'color1' => $faker->hexColor(),
                'color2' => $faker->hexColor(),
                'color3' => $faker->hexColor(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
