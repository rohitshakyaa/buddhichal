<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_client;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use stdClass;
use Throwable;

class ProductController extends Controller
{

    public function index()
    {
        return view("pages.product.index");
    }

    public function create()
    {
        return view("pages.product.create");
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'priority' => 'required|unique:products,priority',
            'title' => 'required|max:255',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required'
        ]);
        // dd($request->file('images'));
        DB::beginTransaction();
        try {
            Log::info("parameters for storing product.", $request->all());
            $product = new Product;
            $product->title = $request->title;
            $product->price = $request->price;
            $product->priority = $request->priority;
            $product->save();

            foreach ($request->file('images') as $index => $image) {
                $imagePath = $this->storeProductImage($product->id, $image, $index);
                $productImage = ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath
                ]);
            }

            DB::commit();
            return redirect(route('productIndex'))
                ->with('success', 'product added successfully');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput($request->input())
                ->with('danger', 'something went wrong');
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            $productImages = ProductImage::where('product_id', $product->id)->select('id', 'image_path')->get();
            foreach ($productImages as $image) {
                $image->image_path = url($image->image_path);
            };
            $product->images = $productImages;
            return view('pages.product.edit', compact('product'));
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('danger', 'product not found.');
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            $validatedData = request()->validate([
                'priority' => ['required', Rule::unique('products', 'priority')->ignore($id, 'id')],
                'title' => 'required|max:255',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'required'
            ]);
            DB::beginTransaction();
            try {
                Log::info("parameter for updating product", $request->all());

                $product->priority = $request->priority;
                $product->title = $request->title;
                $product->price = $request->price;
                $product->save();

                $imageCount = count($product->product_images);
                $removedImageIds = isset($request->removedImageIds) ? $request->removedImageIds : [];
                if (count($removedImageIds) == $imageCount && !$request->images) {
                    return back()
                        ->withInput($request->input())
                        ->with('danger', "You can't update with empty images");
                }

                if ($request->hasFile('images'))
                    foreach ($request->file('images') as $index => $image) {
                        $imagePath = $this->storeProductImage($product->id, $image, $index);
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $imagePath
                        ]);
                        Log::info("product images has been updated.");
                    }

                if (count($removedImageIds)) {
                    foreach ($removedImageIds as $imageId) {
                        $image = ProductImage::find($imageId);
                        if (!$image) {
                            return back()
                                ->withInput($request->input())
                                ->with('danger', 'Image not found while removing');
                        }
                        File::delete(public_path($image->image_path));
                        $image->delete();
                    }
                }
                Log::info("Data for products has been updated successfully", $product->toArray());
                DB::commit();
                return redirect(route('productIndex'))->with('success', 'Product updated successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);
                return back()
                    ->withInput($request->input())
                    ->with('danger', "Something went wrong");
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        foreach ($product->product_images as $image) {
            File::delete(public_path($image->image_path));
        }
        $product->delete();
        return redirect(route('productIndex'))
            ->with('success', 'product and its images have been deleted.');
    }




    private function storeProductImage($productId, $imageFile, $index)
    {
        $imagePath = "images/products";
        $path = public_path($imagePath);
        $imageName = $productId . '-' . time() . '.' . $index . '.' . $imageFile->extension();
        $imageFile->move($path, $imageName);
        return $imagePath . '/' . $imageName;
    }
}
