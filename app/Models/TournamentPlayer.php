<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentPlayer extends Model
{
    use HasFactory;
    protected $table = 'tournament_players';

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
