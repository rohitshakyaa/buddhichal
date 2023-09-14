<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Tournament;
use App\Models\Tournament_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TournamentApiAdminController extends Controller
{
    public function create(Request $request)
    {

        request()->validate([
            'register' => 'boolean',
            'number' => 'required|integer',
            'title' => 'required|min:2',
            'description' => 'required',
            'start_date' => 'required|date_format:F j,y',
            'end_date' => 'required|date_format:F j,y,',
            'totalprize' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();

        try
        {  

            $tournament = Tournament::create([
                'register' => $request->register,
                'number' => $request->number,
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->statr_date,
                'end_date' => $request->end_date,
                'total_prize' => $request->total_prize
            ]);

            $images = [];

            foreach($request->file('images') as $image)
            {
                $imageName = 'tmt'.'-'.$tournament->id.'-'.now()->format('YmdHis');
                $image->storeAs('public/images',$imageName);

                $tournamentImage = Tournament_image::create([
                    'tournament_id' => $tournament->id,
                    'image_name' => $imageName
                ]);
            }

            DB::commit();

           return ApiResponseHelper::successResponseWithData($tournament);

        } catch(\Exception $e){
            DB::rollBack();
            return ApiResponseHelper::errorResponse('Error creating tournament and image');
        }
           


       

    }
    

   
            
}
