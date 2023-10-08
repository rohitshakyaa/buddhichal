<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Tournament;
use Illuminate\Http\Request;

class ProductApiAdminController extends Controller
{
  public function index(Request $request)
  {
    return ApiResponseHelper::errorResponse("This api is in development.");
    $response = [];
    /*
    {
      id: 
      priority: 
      title: 
      price: 
      images: {
        image_path:
        image_url:
      }
    }
    */
    return ApiResponseHelper::successResponseWithData($response);
  }
}
