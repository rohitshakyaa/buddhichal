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
        $teamChampions = TeamChampion::with(['team_champion_images' => function ($query) {
            $query->select('team_champion_id', 'image_path');
        }])
            ->select("id", "title", "priority", "captain_name", "location", "location", "phone_number", "year")
            ->orderBy("priority", "asc")
            ->get();
        $response = $teamChampions->map(function ($teamChampion) {
            return [
                'id' => $teamChampion->id,
                'title' => $teamChampion->title,
                'priority' => $teamChampion->priority,
                'captain_name' => $teamChampion->captain_name,
                'location' => $teamChampion->location,
                'phone_number' => $teamChampion->phone_number,
                'year' => $teamChampion->year,
                'images' =>  $teamChampion->team_champion_images->map(function ($image) {
                    return [
                        'image_path' => $image->image_path,
                        'image_url' => url($image->image_path),
                    ];
                })->toArray(),
            ];
        });
        return ApiResponseHelper::successResponseWithData($response);
    }
}
