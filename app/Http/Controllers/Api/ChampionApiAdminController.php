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
        } else {
            $champions = Champion::where('gender', $gender);
        }
        return ApiResponseHelper::successResponseWithData($champions);
    }
}
