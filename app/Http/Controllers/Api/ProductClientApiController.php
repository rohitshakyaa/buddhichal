<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Banner;
use Illuminate\Http\Request;

class ProductClientApiController extends Controller
{
  public function index()
  {
    return ApiResponseHelper::errorResponse("This api is in development.");
    $productClients = [];
    return ApiResponseHelper::successResponseWithData($productClients);
  }

  public function store(Request $request)
  {
    return ApiResponseHelper::errorResponse("This api is in development.");
  }
}
