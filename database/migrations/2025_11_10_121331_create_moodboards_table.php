<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoodboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('moodboards', function (Blueprint $table) {
        $table->bigIncrements('id');              // Primary Key
        $table->string('code')->unique()->nullable(); // Kode unik moodboard (contoh : md_001)
        $table->string('title');                 // Judul moodboard
        $table->text('description')->nullable(); // Deskripsi moodboard
        $table->string('theme')->nullable();     // Tema moodboard (misal: “Minimalist”, “Retro”)
        $table->string('creator')->nullable();   // Nama desainer/pembuat
        $table->string('color_key_1')->nullable();   // Warna utama 1
        $table->string('color_key_2')->nullable();   // Warna utama 2
        $table->string('color_key_3')->nullable();  // Warna utama 3
        $table->string('image_path')->nullable();    // Path ke file gambar
        $table->timestamps(); 
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moodboards');
    }
}
