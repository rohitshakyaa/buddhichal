<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Champion;
use Illuminate\Validation\ValidationException;

class ChampionApiController extends Controller
{
    public function index($gender = null)
    {
        $acceptedGender = ["male", "female"];

        // Check if the provided gender is valid
        if (!is_null($gender) && !in_array($gender, $acceptedGender)) {
            return ApiResponseHelper::errorResponse("Invalid champion type; accepted types: male, female");
        }

        $champions = Champion::select(['id', 'name', 'from_address', 'game_at_address', 'gender', 'year', 'image'])
            ->when(!is_null($gender), function ($query) use ($gender) {
                $genderShort = $gender == "male" ? "M" : "F";
                return $query->where('gender', $genderShort);
            })
            ->get();

        $champions->each(function ($champion) {
            $champion->image = url($champion->image);
        });

        return ApiResponseHelper::successResponseWithData($champions);
    }
}
