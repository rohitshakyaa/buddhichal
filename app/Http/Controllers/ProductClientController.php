<?php

namespace App\Http\Controllers;

use App\Models\Product_client;
use Illuminate\Http\Request;

class ProductClientController extends Controller
{
    public function index()
    {
        // here product client
        return view("errors.dev");
        return view("pages.product client.index");
    }

    public function destroy($id)
    {
        dd($id);
    }

    //
    public function clientCreate(Request $request, $product_id)
    {
        $client = request()->validate([
            'product_id' => $product_id,
            'name' => 'required|max:255|min:2',
            'phone_number' => 'required|max:10',
            'address' => 'required|max:255'
        ]);
        Product_client::create($client);
        session()->flash('info', "Product added successfully");
    }
}
