<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_client;
use Illuminate\Http\Request;
use stdClass;

class ProductController extends Controller
{

    public function index()
    {
        return view("errors.dev");
        return view("pages.product.index");
    }

    public function create()
    {
        return view("errors.dev");
        return view("pages.product.create");
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit($id)
    {
        $product = new stdClass;
        $product->id = 1;
        $product->title = "test";
        $product->price = 100;
        $product->priority = 1;
        $product->images = [];
        // dd($product);
        /*
        {
            id:
            price:
            priority:
            title:
            image_path: url(),
        }
        */
        return view("pages.product.edit", compact('product'));
    }

    public function update(Request $request, $id)
    {
        dd($request->all());
    }

    public function destroy($id)
    {
        dump("Destroy");
        dd($id);
    }

    //
    public function showAllProducts()
    {
        $products = Product::all()->latest;
    }

    public function addProduct(Request $request)
    {
        $validatedData = request()->validate([
            'priority' => 'required|unique:products,priority',
            'title' => 'required|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required'
        ]);
        $images = [];
        foreach ($request->file('images') as $image) {
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $images[] = $imageName;
        }

        $product = Product::create([
            'priority' => $validatedData['priority'],
            'title' => $validatedData['title'],
            'images' => $images,
            'price' => $validatedData['price'],
        ]);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            $validatedData = request()->validate([
                'priority' => 'required|unique:products,priority',
                'title' => 'required|max:255',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'required'
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
                $product->images[] = $imageName;
            }

            $product->priority = $validatedData['priority'];
            $product->title = $validatedData['title'];
            $product->price = $validatedData['price'];
            $product->save();
        }
    }
}
