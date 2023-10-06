<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Tournament;

class TournamentApiAdminController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::with(['tournament_images' => function ($query) {
            $query->select('tournament_id', 'image_path');
        }])
            ->select("id", "register", "number", "title", "description", "start_date", "end_date", "total_prize")
            ->get();

        $response = $tournaments->map(function ($tournament) {
            return [
                'id' => $tournament->id,
                'register' => $tournament->register,
                'number' => $tournament->number,
                'title' => $tournament->title,
                'description' => $tournament->description,
                'total_prize' => $tournament->total_prize,
                'start_date' => $tournament->start_date,
                'end_date' => $tournament->end_date,
                'images' =>  $tournament->tournament_images->map(function ($image) {
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
