<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TournamentPlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.tournament.playerIndex");
    }
}
