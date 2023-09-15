<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentImage extends Model
{
    use HasFactory;
    protected $table = 'tournament_images';
    protected $guarded = [''];
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
