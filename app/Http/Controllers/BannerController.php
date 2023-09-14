<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
            'caption' => 'required|max:255',
            'link' => 'required|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:3062',
        ]);
        try {
            Log::info("Parameters for creating banner: ", $request->all());
            DB::beginTransaction();
            $banner = new Banner;
            $banner->caption = $request->get('caption');
            $banner->link = $request->get('link');
            $banner->image = "";
            $banner->save();
            $banner->image = $this->storeBannerImage($banner->id, $request->image);
            $banner->push();
            Log::info("Data saved for banner with values: ", $banner->toArray());
            DB::commit();
            return redirect(route('bannerIndex'))->with('success', "Banner has been created successfully");
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput($request->input())
                ->with('danger', "Something went wrong");
        }
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
        $banner = Banner::findOrFail($id);
        $banner->image = url($banner->image);
        return view('pages.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);
        $request->validate([
            'caption' => 'required|max:255',
            'link' => 'required|max:255',
            'image' => 'image|mimes:jpg,jpeg,png|max:3062',
        ]);
        $banner->caption = $request->get('caption');
        $banner->link = $request->get('link');
        if ($request->file('image')) {
            File::delete(public_path($banner->image));
            $banner->image = $this->storeBannerImage($banner->id, $request->file('image'));
        }
        $banner->save();
        return redirect(route('bannerIndex'))->with('success', 'Banner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect(route('bannerIndex'))->with('success', "Banner deleted successfully");
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
