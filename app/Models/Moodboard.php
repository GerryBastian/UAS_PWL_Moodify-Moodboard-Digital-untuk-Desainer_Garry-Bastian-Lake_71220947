<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Moodboard extends Model

{
    protected $table = 'moodboards';

    protected $fillable = [
        'code', 'title', 'description', 'theme', 'creator',
        'color_key_1', 'color_key_2', 'color_key_3',
        'image_path'
    ];
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'moodboard_id', 'user_id');
    }
}
