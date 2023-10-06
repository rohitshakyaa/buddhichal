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
