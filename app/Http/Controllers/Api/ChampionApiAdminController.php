<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Champion;

class ChampionApiAdminController extends Controller
{
    public function index($gender = NULL)
    {
        if ($gender == NULL) {
            $champions = Champion::all();
            foreach ($champions as $champion) {
                $champion->image = url($champion->image);
            }
        } else {
            $champions = Champion::where('gender', $gender)->all();
            foreach ($champions as $champion) {
                $champion->image = url($champion->image);
            }
        }
        return ApiResponseHelper::successResponseWithData($champions);
    }
}
