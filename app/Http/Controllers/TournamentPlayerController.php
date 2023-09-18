<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentPlayer;
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

    public function create()
    {
    }

    public function store(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);
        if ($tournament) {
            $request->validate([
                'name' => 'required',
                'phone_number' => 'required',
                'address' => 'required',
                'fide_id' => 'required',
                'dob' => 'required',
                'fide_rading' => 'required',
                'email' => 'required'
            ]);

            $tournamentPlayer = new TournamentPlayer;
            $tournamentPlayer->tournament_id = $id;
            $tournamentPlayer->name = $request->name;
            $tournamentPlayer->address = $request->address;
            $tournamentPlayer->fide_id = $request->fide_id;
            $tournamentPlayer->dob = $request->dob;
            $tournamentPlayer->fide_rating = $request->fide_rating;
            $tournamentPlayer->email = $request->email;
            $tournamentPlayer->save();
            return redirect(route(''))->with('success', 'you have registered successfully');
        }
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }
}
