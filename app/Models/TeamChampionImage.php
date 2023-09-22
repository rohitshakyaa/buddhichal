<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamChampionImage extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function team_champion()
    {
        return $this->belongsTo(TeamChampion::class);
    }
}
