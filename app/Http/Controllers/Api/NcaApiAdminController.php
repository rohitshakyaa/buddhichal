<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\Nca;
use Illuminate\Http\Request;

class NcaApiAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ncaMembers = Nca::select("id", "position", "name", "phone_number", "post", "email", "image")->orderBy('position', 'asc')->get();
        foreach ($ncaMembers as $ncaMember) {
            $imagePath = $ncaMember->image;
            $ncaMember->image = url($imagePath);
        }
        return ApiResponseHelper::successResponseWithData($ncaMembers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
