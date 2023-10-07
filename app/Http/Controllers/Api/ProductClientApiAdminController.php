<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Banner;
use Illuminate\Http\Request;

class ProductClientApiAdminController extends Controller
{
  public function index()
  {
    $productClients = [];
    return ApiResponseHelper::successResponseWithData($productClients);
  }
}
