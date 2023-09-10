<?php

namespace App\Http\Controllers;

use App\Models\Champion;
use Illuminate\Http\Request;

class ChampionController extends Controller
{
    //
    public function getAllChampions($gender = NULL)
    {
        if($gender == NULL)
        {
            $champions = Champion::all();
        }else{
            $champions = Champion::where('gender', $gender);

        }  
    }

    public function addChampions(Request $request)
    {
        $validatedData = request()->validate([
            'from' => 'required|max:255',
            'game_at' => 'required',
            'gender' => 'required|in:M,F','r',
            'image' =>'image|mimes:jpeg,jpg,png,gif|max:2048',
            'date' => 'required|date_format:F j, Y'
        ]);
        if( $request->hasFile('image'))
        {
            $imageName = time().'-'.$request->image->getClientOriginalName();
            $request->image->storeAs('public/images',$imageName);
        }
        $validatedData['image'] = $imageName;

        $champion = Champion::create($validatedData);   
    }

}
