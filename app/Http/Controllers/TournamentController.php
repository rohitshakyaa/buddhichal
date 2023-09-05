<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function showAllTournaments()
    {
        $tournaments = Tournament::all();
        return view('tournament',compact('tournaments'));
    }

}
