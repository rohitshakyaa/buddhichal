<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamChampion extends Model
{
    use HasFactory;
    protected $table = 'team_champions';

    protected $guarded = [''];

    public function team_champion_images()
    {
        return $this->hasMany(TeamChampionImage::class);
    }
}
