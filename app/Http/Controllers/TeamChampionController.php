<?php

namespace App\Http\Controllers;

use App\Models\TeamChampion;
use App\Models\TeamChampionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeamChampionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.teamchampions.index');
    }

    public function create()
    {
        return view('pages.teamchampions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'priority' => 'required|integer',
            'captain_name' => 'required|max:255',
            'location' => 'required|max:255',
            'phone_number' => 'required|min:8',
            'year' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        DB::beginTransaction();
        try {
            Log::info("prarameters for team champions");
            $teamChampion = new TeamChampion;
            $teamChampion->priority = $request->priority;
            $teamChampion->captain_name = $request->captain_name;
            $teamChampion->location = $request->location;
            $teamChampion->phone_number = $request->phone_number;
            $teamChampion->year = $request->year;
            $teamChampion->save();

            Log::info("teamchampion has been added", $teamChampion->toArray());

            $images = [];

            foreach ($request->file('images') as $image) {
                $imagePath = "images/teamChampions";
                $path = public_path($imagePath);
                $imageName = $teamChampion->id . '-' . now()->format('YmdHis') . '.' . $image->extension();
                $image->move($path, $imageName);

                $tournamentImage = TeamChampionImage::create([
                    'team_champion_id' => $teamChampion->id,
                    'image_path' => $imagePath . '/' . $imageName
                ]);
            }
            DB::commit();
            return redirect(route('teamChampionIndex'))->with('success', 'team champions created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()
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
            $teamChampionImage = TeamChampionImage::where('team_champion_id', $teamChampion->id)->get();
            return view('pages.champions.edit',compact('teamChampion','teamChampinImage'));
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
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif'
            ]);

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

                $images = [];

                foreach ($request->file('images') as $image) {
                    $imagePath = "images/teamChampion";
                    $path = public_path($imagePath);
                    $imageName = $teamChampion->id . '-' . now()->format('YmdHis') . '.' . $image->extension();
                    $image->move($path, $imageName);
                    DB::table('team_champion_images')
                        ->where('team_champion_id', $teamChampion->id)
                        ->update(['image_path' => $imagePath . '/' . $imageName]);
                }
                DB::commit();
                return redirect(route('teamChampionIndex'))->with('success', 'team champions updated successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);
                return back()
                    ->with('danger', 'something went wrong');
            }
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $teamChampion = TeamChampion::findOrFail($id);
            $teamChampion->delete();
            DB::table('team_champion_mages')
                ->where('team_champion_id', $id)
                ->delete();

            DB::commit();
            return redirect(route('teamChampionIndex'))
                ->with('success', 'TeamChampion and its images have been deleted.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->with('danger', 'Something went wrong while deleting the TeamChampion and images.');
        }
    }
}
