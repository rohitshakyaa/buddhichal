<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function tournament_players()
    {
        return $this->hasMany(TournamentPlayer::class);
    }

    public function tournament_images()
    {
        return $this->hasMany(TournamentImage::class);
    }
}
