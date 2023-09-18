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
    public function index($gender = NULL)
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
            'from' => 'required|max:255',
            'game_at' => 'required',
            'gender' => 'required|in:M,F',
            'image' => 'image|mimes:jpeg,jpg,png,gif',
            'date' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $champion = Champion::create($validatedData);
            $champion->image = $this->storeChampionImage($champion->id, $request->file('image'));
            $champion->save();
            DB::commit();
            return redirect(route('championIndex'))->with('success', 'champion added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()
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
            return view('pages.champion.edit', compact('champion'));
        } else {
            Log::error("Champion notfound for id: $id");
            return back()->with('danger', 'Champion not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'from' => 'required|max:255',
            'game_at' => 'required',
            'gender' => 'required|in:M,F',
            'image' => 'image|mimes:jpeg,jpg,png,gif',
            'date' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $champion = Champion::findOrFail($id);
            if ($champion) {
                $champion->from = $request->from;
                $champion->game_at = $request->game_at;
                $champion->gender = $request->gender;
                $champion->date = $request->date;
                $champion->save();
                $champion->image = $this->storeChampionImage($champion->id, $request->file('image'));
                $champion->save();
                DB::commit();
                return redirect(route('championIndex'))->with('success', 'champion updated successfully');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()
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
