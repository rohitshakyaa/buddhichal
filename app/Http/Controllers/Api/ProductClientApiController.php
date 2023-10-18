<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Product;
use App\Models\ProductClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductClientApiController extends Controller
{
  public function index(Request $request)
  {
    // $productClient = ProductClient::select('id', 'product_id', 'name', 'phone_number', 'address')
    //   ->orderBy("id", "asc")
    //   ->get();

    if ($productId = $request->get('product_id')) {
      $clients = ProductClient::where('product_id', $productId)->get();
    } else {
      $clients = ProductClient::all();
    }
    foreach ($clients as $client) {
      $client->productName = $client->product->title;
    }

    return ApiResponseHelper::successResponseWithData($clients);
  }

  public function store(Request $request, Product $product)
  {
    Log::info("Parameters for storing product client: ", $request->all());
    $request->validate([
      'product_id' => 'required',
      'name' => 'required|max:255|min:2',
      'phone_number' => 'required|max:10',
      'address' => 'required|max:255'
    ]);

    // Validate product existence
    if (!$product->exists($request->product_id)) {
      Log::error("Product not found with : $request->product_id");
      return ApiResponseHelper::notFoundResponse("Product not found with id :$request->product_id");
    }

    // Create a new product client
    $client = ProductClient::create($request->only([
      'product_id',
      'name',
      'phone_number',
      'address'
    ]));

    Log::info("Tournament Player stored successfully", $client->toArray());

    return ApiResponseHelper::successResponse("client created successfully.");
  }
}
