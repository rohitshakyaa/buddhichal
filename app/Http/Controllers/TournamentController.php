<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponseHelper;
use App\Models\Tournament;
use App\Models\TournamentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
        Log::info("parameter for storing tournament", $request->all());
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

            foreach ($request->file('images') as $index => $image) {
                $imagePath = $this->storeTournamentImage($tournament->id, $image, $index);
                TournamentImage::create([
                    'tournament_id' => $tournament->id,
                    'image_path' => $imagePath
                ]);
            }
            DB::commit();
            return redirect(route('tournamentIndex'))->with('success', 'Tournament created successfully.');
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
        Log::info("parameter for updating tournament", $request->all());
        $request->validate([
            'register' => 'required',
            'number' => 'required',
            'title' => 'required|min:2',
            'start_date' => 'required',
            'end_date' => 'required',
            'total_prize' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        DB::beginTransaction();
        try {
            Log::info("parameter for updating tournament", $request->all());
            $tournament->register = $request->register;
            $tournament->number = $request->number;
            $tournament->title = $request->title;
            $tournament->description = $request->description;
            $tournament->start_date = $request->start_date;
            $tournament->end_date = $request->end_date;
            $tournament->total_prize = $request->total_prize;
            $tournament->save();

            $imageCount = count($tournament->tournament_images);
            $removedImageIds = isset($request->removedImageIds) ? $request->removedImageIds : [];
            if (count($removedImageIds) == $imageCount && !$request->images) {
                return back()
                    ->withInput($request->input())
                    ->with('danger', "You can't update with empty images");
            }

            if ($request->hasFile('images'))
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $this->storeTournamentImage($tournament->id, $image, $index);
                    TournamentImage::create([
                        'tournament_id' => $tournament->id,
                        'image_path' => $imagePath
                    ]);
                    Log::info("Tournament images has been updated.");
                }

            if (count($removedImageIds)) {
                foreach ($removedImageIds as $imageId) {
                    $image = TournamentImage::find($imageId);
                    if (!$image) {
                        return back()
                            ->withInput($request->input())
                            ->with('danger', 'Image not found while removing');
                    }
                    File::delete(public_path($image->image_path));
                    $image->delete();
                }
            }

            DB::commit();
            return redirect(route('tournamentIndex'))->with('success', 'Tournament updated successfully');
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
            if ($tournament) {
                foreach ($tournament->tournament_images as $image) {
                    File::delete(public_path($image->image_path));
                }
            }
            $tournament->delete();
            DB::commit();
            Log::info("Tournament with $id has been deleted successfully.");
            return redirect(route('tournamentIndex'))->with('success', 'Tournament and its images have been deleted.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()->with('danger', 'Something went wrong while deleting the tournament and images.');
        }
    }

    private function storeTournamentImage($tournamentId, $imageFile, int $index = 0)
    {
        $imagePath = "images/tournaments";
        $path = public_path($imagePath);
        $imageName = $tournamentId . '-' . time() . '.' . $index . '.' . $imageFile->extension();
        $imageFile->move($path, $imageName);
        return $imagePath . '/' . $imageName;
    }
}
