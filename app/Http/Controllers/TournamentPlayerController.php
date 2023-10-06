<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentPlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TournamentPlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.tournament player.index");
    }

    public function create()
    {
        return view("pages.tournament.playerCreate");
    }
    /**
     * @param $id is the the id of the tournament 
     */
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
            Log::info("Data saved for tournament player with values: ", $request->all());
            $tournamentPlayer = new TournamentPlayer;
            $tournamentPlayer->tournament_id = $id;
            $tournamentPlayer->name = $request->name;
            $tournamentPlayer->address = $request->address;
            $tournamentPlayer->fide_id = $request->fide_id;
            $tournamentPlayer->dob = $request->dob;
            $tournamentPlayer->fide_rating = $request->fide_rating;
            $tournamentPlayer->email = $request->email;
            $tournamentPlayer->save();
            Log::info("tournament player created: ", $tournamentPlayer->toArray());
            return redirect(route('pages.tournament.playerIndex'))->with('success', 'you have registered successfully');
        }
    }

    public function edit($id)
    {
        $tournamentPlayer = TournamentPlayer::findOrFail($id);
        if ($tournamentPlayer) {
            return view('pages.tournament.playerIndex', compact('tournamentPlayer'));
        } else {
            Log::error("tournamentPlayer notfound for id: $id");
            return back()->with('danger', 'tournamentPlayer not found.');
        }
    }

    /**
     * @param $id is the the id of the player 
     */
    public function update(Request $request, $id, $tournamentId)
    {
        $tournamentPlayer = TournamentPlayer::findOrFail($id);
        if ($tournamentPlayer) {
            $request->validate([
                'name' => 'required',
                'phone_number' => 'required',
                'address' => 'required',
                'fide_id' => 'required',
                'dob' => 'required',
                'fide_rading' => 'required',
                'email' => 'required'
            ]);
            Log::info("Data saved for tournament player with values: ", $request->all());
            $tournamentPlayer->tournament_id = $tournamentId;
            $tournamentPlayer->name = $request->name;
            $tournamentPlayer->address = $request->address;
            $tournamentPlayer->fide_id = $request->fide_id;
            $tournamentPlayer->dob = $request->dob;
            $tournamentPlayer->fide_rating = $request->fide_rating;
            $tournamentPlayer->email = $request->email;
            $tournamentPlayer->save();
            Log::info("tournament player updated: ", $tournamentPlayer->toArray());
            return redirect(route('tournamentPlayerIndex'))->with('success', 'Player information updated successfully');
        }
    }

    public function destroy($id)
    {
        $tournamentPlayer = TournamentPlayer::findOrFail($id);
        $tournamentPlayer->delete();
        return redirect(route('tournamentPlayerIndex'))
            ->with('success', 'Player deleted successfully');
    }
}
