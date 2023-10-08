<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerApiController extends Controller
{
    public function index()
    {
        $banners = Banner::select("id", "caption", "link", "image")->get();
        $banners->each(function ($banner) {
            $banner->image = url($banner->image);
        });
        return ApiResponseHelper::successResponseWithData($banners);
    }
}
