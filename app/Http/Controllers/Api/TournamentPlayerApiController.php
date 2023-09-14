<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use Illuminate\Http\Request;

class TournamentPlayerApiController extends Controller
{
    public function index()
    {
        return ApiResponseHelper::successResponseWithData([]);
    }
}
