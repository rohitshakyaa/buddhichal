<?php

namespace App\Http\Controllers;

use App\Models\ProductClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductClientController extends Controller
{
    public function index()
    {
        // here product client
        return view("errors.dev");
        return view("pages.product client.index");
    }

    public function create()
    {
        return view("pages.product client.index");
    }

    public function store(Request $request, $product_id)
    {
        Log::info('parameters for storing the clients', $request->all());
        $validatedData = request()->validate([
            'product_id' => $product_id,
            'name' => 'required|max:255|min:2',
            'phone_number' => 'required|max:10',
            'address' => 'required|max:255'
        ]);
        $client = ProductClient::create($validatedData);
        Log::info("Data for client stored successfully", $client->toArray());
        session()->flash('info', "Product added successfully");
    }

    public function edit($id)
    {
        $client = ProductClient::findOrFail($id);
        if ($client) {
            return redirect(route('pages.product client.edit'), compact('client'));
        } else {
            Log::error("client not found for id: $id");
            return back()
                ->with('danger', 'client not found.');
        }
    }


    public function update(Request $request, $id, $product_id)
    {
        $client = ProductClient::findOrFail($id);
        if ($client) {
            $request->validate([
                'product_id' => $product_id,
                'name' => 'required|max:255|min:2',
                'phone_number' => 'required|max:10',
                'address' => 'required|max:255'
            ]);
            $client->product_id = $product_id;
            $client->name = $request->name;
            $client->phone_number = $request->phone_number;
            $client->address = $request->address;
            $client->save();
            Log::info('Data for client updated successfully');
        } else {
            Log::error("client not found for id: $id");
            return back()
                ->withInput($request->input())
                ->with('danger', 'client not found');
        }
    }

    public function destroy($id)
    {
        $client = ProductClient::findOrFail($id);
        if ($client) {
            $client->delete();
            Log::info('client deleted successfully');
            return redirect(route('pages.product client.index'))
                ->with('success', 'client deleted successfully');
        } else {
            Log::error("client not found for id: $id");
            return back()
                ->withInput(request()->input())
                ->with('danger', 'client not found');
        }
    }
}
