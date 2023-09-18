<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team_champion extends Model
{
    use HasFactory;
    protected $table = 'team_champions';

    protected $guarded = [''];
}
