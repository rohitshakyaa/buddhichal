<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponseHelper;
use App\Models\BookType;
use Illuminate\Http\Request;

class BookTypeApiController extends Controller
{
    public function index()
    {
        $bookTypes = BookType::select("id", "title")->get();
        return ApiResponseHelper::successResponseWithData($bookTypes);
    }
}
