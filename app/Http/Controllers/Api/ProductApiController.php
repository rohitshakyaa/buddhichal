<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Product;
use App\Models\Tournament;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
  public function getDataForDataTable()
  {
    $product = Product::with(['product_images' => function ($query) {
      $query->select('product_id', 'image_path');
    }])
      ->select('id', 'priority', 'title', 'price')
      ->orderBy("priority", "asc")
      ->get();

    $product->transform(function ($product) {
      $product->images = $product->product_images->map(function ($image) {
        return [
          'image_path' => $image->image_path,
          'image_url' => url($image->image_path),
        ];
      })->toArray();
      unset($product->product_images);
      return $product;
    });
    return ApiResponseHelper::successResponseWithData($product);
  }

  public function index()
  {
    $product = Product::with(['product_images' => function ($query) {
      $query->select('product_id', 'image_path');
    }])
      ->select('id', 'priority', 'title', 'price')
      ->orderBy("priority", "asc")
      ->get();

    $product->transform(function ($product) {
      $product->images = $product->product_images->map(function ($image) {
        return url($image->image_path);
      })->toArray();

      unset($product->product_images);

      return $product;
    });

    return ApiResponseHelper::successResponseWithData($product);
  }
}
