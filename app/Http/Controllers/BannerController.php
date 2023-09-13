<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.banner.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.banner.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required',
            'link' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:3062',
        ]);
        try {
            Log::info("Parameters for creating banner: " . $request->all());
            DB::beginTransaction();
            $banner = new Banner;
            $banner->caption = $request->get('caption');
            $banner->link = $request->get('link');
            $banner->image = "";
            $banner->save();
            $banner->image = $this->storeBannerImage($banner->id, $request->image);
            $banner->push();
            DB::commit();
            Log::info("Data saved for banner with values: " . $banner->all());
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
        }
        return redirect(route('bannerIndex'))->with('success', "Banner has been created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function storeBannerImage($bannerId, $imageFile)
    {
        $imagePath = "images/banners";
        $path = public_path($imagePath);
        $imageName = $bannerId . '-' . time() . '.' . $imageFile->extension();
        $imageFile->move($path, $imageName);
        return $imagePath . '/' . $imageName;
    }
}
