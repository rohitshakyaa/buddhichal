<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Tournament;
use App\Models\TournamentPlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function store(Request $request, Tournament $tournament)
    {
        Log::info("Parameters for storing tournament players: ", $request->all());

        $request->validate([
            'tournament_id' => 'required',
            'name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'fide_id' => 'required',
            'dob' => 'required',
            'fide_rating' => 'required',
            'email' => 'required|unique:tournament_players',
        ]);

        // Validate tournament existence
        if (!$tournament->exists($request->tournament_id)) {
            Log::error("Tournament not found with {$request->tournament_id}");
            return ApiResponseHelper::notFoundResponse("Tournament not found with id {$request->tournament_id}");
        }

        // Create a new tournament player
        $tournamentPlayer = TournamentPlayer::create($request->only([
            'tournament_id',
            'name',
            'phone_number',
            'address',
            'fide_id',
            'dob',
            'fide_rating',
            'email',
        ]));

        Log::info("Tournament Player stored successfully", $tournamentPlayer->toArray());

        return ApiResponseHelper::successResponse("Player registered successfully.");
    }
}
