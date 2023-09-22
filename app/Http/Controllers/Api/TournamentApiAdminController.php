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
            ->select("register", "number", "title", "description", "start_date", "end_date", "total_prize")
            ->get();

        return ApiResponseHelper::successResponseWithData($tournaments);
    }
}
