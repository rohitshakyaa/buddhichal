<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\TeamChampion;
use Illuminate\Http\Request;

class TeamChampionApiController extends Controller
{
    public function getDataForDataTable()
    {
        $teamChampions = TeamChampion::with(['team_champion_images' => function ($query) {
            $query->select('team_champion_id', 'image_path');
        }])
            ->select("id", "title", "priority", "captain_name", "location", "location", "phone_number", "year")
            ->orderBy("priority", "asc")
            ->get();

        $teamChampions->transform(function ($teamChampion) {
            $teamChampion->images = $teamChampion->team_champion_images->map(function ($image) {
                return [
                    'image_path' => $image->image_path,
                    'image_url' => url($image->image_path),
                ];
            })->toArray();
            unset($teamChampion->team_champion_images);
            return $teamChampion;
        });
        return ApiResponseHelper::successResponseWithData($teamChampions);
    }

    public function index()
    {
        $teamChampions = TeamChampion::with(['team_champion_images' => function ($query) {
            $query->select('team_champion_id', 'image_path');
        }])
            ->select("id", "title", "priority", "captain_name", "location", "location", "phone_number", "year")
            ->orderBy("priority", "asc")
            ->get();

        $teamChampions->transform(function ($teamChampion) {
            $teamChampion->images = $teamChampion->team_champion_images->pluck('image_path')->map(function ($image) {
                return url($image);
            })->toArray();
            unset($teamChampion->team_champion_images);
            return $teamChampion;
        });

        return ApiResponseHelper::successResponseWithData($teamChampions);
    }
}
