<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\TeamChampion;
use Illuminate\Http\Request;

class TeamChampionApiAdminController extends Controller
{
    public function index()
    {
        $teamChampions = TeamChampion::with('team_champion_images')
            ->select("priority", "captain_name", "location", "location", "phone_number", "year")
            ->get();
        return ApiResponseHelper::successResponseWithData($teamChampions);
    }
}
