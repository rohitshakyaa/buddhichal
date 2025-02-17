<?php

namespace App\Http\Controllers;

use App\Models\Nca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PgSql\Lob;
use Throwable;

class NcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.nca.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.nca.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'post' => 'required',
            'position' => 'required',
            'name' => 'required',
            'phone_number' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email'
        ]);


        DB::beginTransaction();
        try {
            Log::info("Parameters from creating ncas", $request->all());
            $nca = new Nca;
            $nca->post = $request->post;
            $nca->position = $request->position;
            $nca->name = $request->name;
            $nca->phone_number = $request->phone_number;
            $nca->email = $request->email;
            $nca->image = " ";
            $nca->save();
            $nca->image = $this->storeNcaImage($nca->id, $request->image);
            $nca->push();
            Log::info("Data saved for ncas with values: ", $nca->toArray());

            DB::commit();
            return redirect(route('ncaIndex'))->with('success', 'Nca Member has been added successfully');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput($request->input())
                ->with('danger', "Something went wrong");
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
        $nca = Nca::findOrFail($id);
        $nca->image = url($nca->image);
        return view("pages.nca.edit", compact('nca'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nca = Nca::findOrFail($id);
        $validatedData = request()->validate([
            'post' => 'required',
            'position' => 'required',
            'name' => 'required',
            'phone_number' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email'
        ]);
        $nca->post = $validatedData['post'];
        $nca->position = $validatedData['position'];
        $nca->name = $validatedData['name'];
        $nca->phone_number = $validatedData['phone_number'];
        $nca->email = $validatedData['email'];
        if ($request->hasFile('image')) {
            File::delete(public_path($nca->image));
            $nca->image = $this->storeNcaImage($nca->id, $request->file('image'));
        }
        $nca->save();
        return redirect(route('ncaIndex'))->with('success', 'Nca Member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nca = Nca::findOrFail($id);
        $nca->delete();
        return redirect(route('ncaIndex'))->with('success', "Nca Member deleted successfully");
    }

    private function storeNcaImage($ncaId, $imageFile)
    {
        $imagePath = "images/ncas";
        $path = public_path($imagePath);
        $imageName = $ncaId . '-' . time() . '.' . $imageFile->extension();
        $imageFile->move($path, $imageName);
        return $imagePath . '/' . $imageName;
    }
}
