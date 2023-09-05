<?php

namespace App\Http\Controllers;

use App\Models\Champion;
use Illuminate\Http\Request;

class ChampionController extends Controller
{
    //
    public function getAllChampions($gender = NULL)
    {
        if($gender == NULL)
        {
            $champions = Champion::all()->get();
        }else{
            $champions = Champion::where('gender', $gender);

        }

        

    }
}
