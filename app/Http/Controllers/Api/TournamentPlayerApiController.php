<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Tournament;
use App\Models\TournamentPlayer;
use Illuminate\Http\Request;

class TournamentPlayerApiController extends Controller
{
    public function index(Request $request)
    {
        if ($tournamentId = $request->get('tournament_id')) {
            $tournamentPlayers = TournamentPlayer::where('tournament_id', $tournamentId)->get();
        } else {
            $tournamentPlayers = TournamentPlayer::all();
        }
        foreach ($tournamentPlayers as $tournamentPlayer) {
            $tournamentPlayer->tournament_title = $tournamentPlayer->tournament->title;
        }
        return ApiResponseHelper::successResponseWithData($tournamentPlayers);
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
            return ApiResponseHelper::successResponseWithData($tournamentPlayer);
        }
    }
}
