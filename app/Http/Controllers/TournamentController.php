<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponseHelper;
use App\Models\Tournament;
use App\Models\TournamentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TournamentController extends Controller
{
    /**
     * Return a page of tournament index with tournament list
     */
    public function index()
    {
        return view('pages.tournament.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.tournament.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'register' => 'required',
            'number' => 'required',
            'title' => 'required|min:2',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'total_prize' => 'required',
            "images" => "required",
            'images.*' => 'image|mimes:jpeg,png,jpg,gif'
        ]);
        DB::beginTransaction();

        try {
            Log::info("parameter for storing tournament", $request->all());
            $tournament = Tournament::create([
                'register' => $request->register,
                'number' => $request->number,
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_prize' => $request->total_prize
            ]);
            Log::info("tournament has been created", $tournament->toArray());

            $images = [];

            foreach ($request->file('images') as $image) {
                $imagePath = $this->storeTournamentImage($tournament->id, $image);
                TournamentImage::create([
                    'tournament_id' => $tournament->id,
                    'image_path' => $imagePath
                ]);
            }
            DB::commit();
            return redirect(route('tournamentIndex'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput($request->input())
                ->with('danger', "Something went wrong");
        }
    }


    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        try {
            $tournament = Tournament::findOrFail($id);
            $tournamentImages = TournamentImage::where('tournament_id', $tournament->id)->get(['id', 'image_path']);
            foreach ($tournamentImages as $image) {
                $image->image_path = url($image->image_path);
            }
            $tournament->images = $tournamentImages;
            return view('pages.tournament.edit', compact('tournament'));
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('danger', 'Tournament not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tournament = Tournament::findOrFail($id);
        $request->validate([
            'register' => 'required',
            'number' => 'required',
            'title' => 'required|min:2',
            'start_date' => 'required',
            'end_date' => 'required',
            'total_prize' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif'
        ]);
        dd($request->all());
        DB::beginTransaction();
        try {
            Log::info("paramenter for storing tournament", $request->all());
            $tournament->register = $request->register;
            $tournament->number = $request->number;
            $tournament->title = $request->title;
            $tournament->description = "I am Rohit.";
            $tournament->start_date = $request->start_date;
            $tournament->end_date = $request->end_date;
            $tournament->total_prize = $request->total_prize;
            $tournament->save();

            foreach ($request->file('images') as $image) {
                $imagePath = $this->storeTournamentImage($tournament->id, $image);
                DB::table('tournament_images')
                    ->where('tournament_id', $tournament->id)
                    ->update(['image_path' => $imagePath]);
            }
            DB::commit();
            return redirect(route('tournamentIndex'))->with('success', 'torunament updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput($request->input())
                ->with('danger', "Something went wrong");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $tournament = Tournament::findOrFail($id);
            $tournament->delete();
            DB::table('tournament_images')
                ->where('tournament_id', $id)
                ->delete();

            DB::commit();
            return redirect(route('tournamentIndex'))->with('success', 'Tournament and its images have been deleted.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()->with('danger', 'Something went wrong while deleting the tournament and images.');
        }
    }

    private function storeTournamentImage($tournamentId, $imageFile)
    {
        $imagePath = "images/banners";
        $path = public_path($imagePath);
        $imageName = $tournamentId . '-' . time() . '.' . $imageFile->extension();
        $imageFile->move($path, $imageName);
        return $imagePath . '/' . $imageName;
    }
}
