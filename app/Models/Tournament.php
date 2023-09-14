<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    public function tournament_players()
    {
        return $this->hasMany(Tournament_player::class);
    }

    public function tournament_images()
    {
        return $this->hasMany(Tournament_image::class);
    }
}
