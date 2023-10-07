<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentApiController extends Controller
{
    public function getDataForDataTable(Request $request)
    {
        $query = Tournament::with(['tournament_images' => function ($query) {
            $query->select('tournament_id', 'image_path');
        }])
            ->select("id", "register", "number", "title", "description", "start_date", "end_date", "total_prize");
        if ($id = $request->get('id')) {
            $query->where("id", $id);
        }
        $tournaments = $query->get();
        $tournaments->transform(function ($tournament) {
            $tournament->images = $tournament->tournament_images->map(function ($image) {
                return [
                    'image_path' => $image->image_path,
                    'image_url' => url($image->image_path),
                ];
            })->toArray();
            unset($tournament->tournament_images);
            return $tournament;
        });
        return ApiResponseHelper::successResponseWithData($tournaments);
    }


    public function index()
    {
        $tournaments = Tournament::with(['tournament_images' => function ($query) {
            $query->select('tournament_id', 'image_path');
        }])
            ->select("id", "register", "number", "title", "description", "start_date", "end_date", "total_prize")
            ->get();

        $tournaments->transform(function ($tournament) {
            $tournament->images = $tournament->tournament_images->map(function ($image) {
                return url($image->image_path);
            })->toArray();

            unset($tournament->tournament_images);

            return $tournament;
        });

        return ApiResponseHelper::successResponseWithData($tournaments);
    }
}
