<?php

namespace App\Http\Controllers;

use App\Models\TeamChampion;
use App\Models\TeamChampionImage;
use App\Models\TournamentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TeamChampionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.team champions.index');
    }

    public function create()
    {
        return view('pages.team champions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'priority' => 'required|integer',
            'captain_name' => 'required|max:255',
            'location' => 'required|max:255',
            'phone_number' => 'required|min:8',
            'year' => 'required',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        DB::beginTransaction();
        try {
            Log::info("prarameters for team champions");
            $teamChampion = new TeamChampion;
            $teamChampion->priority = $request->priority;
            $teamChampion->title = $request->title;
            $teamChampion->captain_name = $request->captain_name;
            $teamChampion->location = $request->location;
            $teamChampion->phone_number = $request->phone_number;
            $teamChampion->year = $request->year;
            $teamChampion->save();

            Log::info("teamchampion has been added", $teamChampion->toArray());

            foreach ($request->file('images') as $image) {
                $imagePath = $this->storeTeamChampionImage($teamChampion->id, $image);
                TeamChampionImage::create([
                    'team_champion_id' => $teamChampion->id,
                    'image_path' => $imagePath
                ]);
            }
            DB::commit();
            return redirect(route('teamChampionIndex'))->with('success', 'team champions created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput($request->input())
                ->with('danger', 'something went wrong');
        }
    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        try {
            $teamChampion = TeamChampion::findOrFail($id);
            $teamChampionImages = TeamChampionImage::where('team_champion_id', $teamChampion->id)->select('id', 'image_path')->get();
            foreach ($teamChampionImages as $image) {
                $image->image_path = url($image->image_path);
            };
            $teamChampion->images = $teamChampionImages;
            return view('pages.team champions.edit', compact('teamChampion'));
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('danger', 'teamChampion not found.');
        }
    }

    public function update(Request $request, $id)
    {
        $teamChampion = TeamChampion::findOrFail($id);
        if ($teamChampion) {

            $request->validate([
                'priority' => 'required|integer',
                'captain_name' => 'required|max:255',
                'location' => 'required|max:255',
                'phone_number' => 'required|min:8',
                'year' => 'required',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif'
            ]);
            $imageCount = count($teamChampion->team_champion_images);
            $removedImageIds = isset($request->removedImageIds) ? $request->removedImageIds : [];
            if (count($removedImageIds) == $imageCount && !$request->images) {
                return back()
                    ->withInput($request->input())
                    ->with('danger', "You can't update with empty images");
            }

            DB::beginTransaction();
            try {
                Log::info("prarameters for team champions");
                $teamChampion->priority = $request->priority;
                $teamChampion->captain_name = $request->captain_name;
                $teamChampion->location = $request->location;
                $teamChampion->phone_number = $request->phone_number;
                $teamChampion->year = $request->year;
                $teamChampion->save();

                Log::info("teamchampion has been added", $teamChampion->toArray());

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $imagePath = $this->storeTeamChampionImage($teamChampion->id, $image);
                        TeamChampionImage::create([
                            'team_champion_id' => $teamChampion->id,
                            'image_path' => $imagePath
                        ]);
                    }
                }

                if (count($removedImageIds)) {
                    foreach ($removedImageIds as $imageId) {
                        $image = TeamChampionImage::find($imageId);
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
                return redirect(route('teamChampionIndex'))->with('success', 'team champions updated successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);
                return back()
                    ->withInput($request->input())
                    ->with('danger', 'something went wrong');
            }
        }
    }

    public function destroy($id)
    {
        $teamChampion = TeamChampion::findOrFail($id);
        foreach ($teamChampion->team_champion_images as $image) {
            File::delete(public_path($image->image_path));
        }
        $teamChampion->delete();
        return redirect(route('teamChampionIndex'))
            ->with('success', 'TeamChampion and its images have been deleted.');
    }

    private function storeTeamChampionImage($teamChampionId, $imageFile)
    {
        $imagePath = "images/team-champions";
        $path = public_path($imagePath);
        $imageName = $teamChampionId . '-' . time() . '.' . $imageFile->extension();
        $imageFile->move($path, $imageName);
        return $imagePath . '/' . $imageName;
    }
}
