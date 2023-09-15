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
            // 'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'total_prize' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);
        DB::beginTransaction();

        try {
            Log::info("paramenter for storing tournament", $request->all());
            $tournament = Tournament::create([
                'register' => $request->register,
                'number' => $request->number,
                'title' => $request->title,
                'description' => "I am Rohit.",
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_prize' => $request->total_prize
            ]);
            Log::info("tournament has been created", $tournament->toArray());

            $images = [];

            foreach ($request->file('images') as $image) {
                $imagePath = "images/tournaments";
                $path = public_path($imagePath);
                $imageName = $tournament->id . '-' . now()->format('YmdHis') . '.' . $image->extension();
                $image->move($path, $imageName);

                $tournamentImage = TournamentImage::create([
                    'tournament_id' => $tournament->id,
                    'image_name' => $imagePath . '/' . $imageName
                ]);
            }

            DB::commit();

            return redirect(route('tournaments'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ApiResponseHelper::errorResponse('Error creating tournament and image');
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
}
