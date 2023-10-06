<?php

namespace App\Http\Controllers;

use App\Models\Champion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChampionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.champions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.champions.create');
    }

    /**
     * store newly created resourse in the storage
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'from_address' => 'required|max:255',
            'game_at_address' => 'required|max:255',
            'gender' => 'required|in:M,F',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
            'year' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Log::info("Data saved for champion with values: ", $validatedData);
            $champion = Champion::create($validatedData);
            $champion->image = $this->storeChampionImage($champion->id, $request->file('image'));
            $champion->save();
            Log::info("Data saved for champion with values: ", $champion->toArray());
            DB::commit();
            return redirect(route('championIndex'))->with('success', 'Champion added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput($request->input())
                ->with('danger', 'something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($gender = NULL)
    {
        if ($gender == NULL) {
            $champions = Champion::all();
        } else {
            $champions = Champion::where('gender', $gender);
        }
        return redirect(route('championIndex'))->with(compact($champions));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $champion = Champion::findOrFail($id);
        if ($champion) {
            $champion->image = url($champion->image);
            return view('pages.champions.edit', compact('champion'));
        } else {
            Log::error("Champion not found for id: $id");
            return back()->with('danger', 'Champion not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'from_address' => 'required|max:255',
            'game_at_address' => 'required|max:255',
            'gender' => 'required|in:M,F',
            'image' => 'image|mimes:jpeg,jpg,png,gif',
            'year' => 'required'
        ]);


        DB::beginTransaction();
        try {
            Log::info("parameters for updating champion", $request->all());

            $champion = Champion::findOrFail($id);
            if ($champion) {
                $champion->name = $validatedData["name"];
                $champion->from_address = $validatedData['from_address'];
                $champion->game_at_address = $validatedData['game_at_address'];
                $champion->gender = $validatedData['gender'];
                $champion->year = $validatedData['year'];
                $champion->save();
                if (isset($validatedData["image"])) {
                    $champion->image = $this->storeChampionImage($champion->id, $request->file('image'));
                    $champion->save();
                }
                DB::commit();
                return redirect(route('championIndex'))->with('success', 'champion updated successfully');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput($request->input())
                ->with('danger', 'something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $champion = Champion::findOrFail($id);
        if ($champion) {
            $champion->delete();
            Log::info("Champions with $id deleted successfully");
            return back()->with("success", "Champion Deleted Successfully!!");
        } else {
            Log::error("champion not found for id: $id");
            return back()
                ->with('danger', 'champion not found');
        }
    }

    /**
     * store image for champions
     */
    private function storeChampionImage($championId, $imageFile)
    {
        $image_path = "images/champions";
        $path = public_path($image_path);
        $imageName = $championId . '-' . now()->format('YmdHis') . '.' . $imageFile->extension();
        $imageFile->move($path, $imageName);
        return $image_path . '/' . $imageName;
    }
}
