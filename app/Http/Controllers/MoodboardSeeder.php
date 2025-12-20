<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moodboard;

class MoodboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat 15 data moodboard menggunakan factory
        Moodboard::factory()->count(15)->create();
    }
}