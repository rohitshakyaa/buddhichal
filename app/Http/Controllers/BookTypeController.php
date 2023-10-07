<?php

namespace App\Http\Controllers;

use App\Models\BookType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BookTypeController extends Controller
{
    public function index()
    {
        return view("pages.book type.index");
    }

    public function create()
    {
        return view("pages.book type.create");
    }

    public function store(Request $request)
    {
        Log::info("Parameters for storing the book type: ", $request->all());
        $request->validate([
            "key" => "required|unique:book_types|max:255",
            "title" => "required|max:255"
        ]);

        $bookType = BookType::create($request->only(['key', 'title']));
        Log::info("Book Type created with params: ", $bookType->toArray());
        return redirect(route("bookTypeIndex"))->with("success", "Book Type created successfully");
    }

    public function edit(string $id)
    {
        $bookType = BookType::findOrFail($id);
        return view("pages.book type.edit", compact('bookType'));
    }

    public function update(Request $request, string $id)
    {
        $bookType = BookType::findOrFail($id);
        $request->validate([
            "key" => ["required", "max:255", Rule::unique("book_types")->ignore($bookType->id)],
            "title" => "required|max:255"
        ]);
        $bookType->update($request->only(['key', 'title']));
        return redirect(route('bookTypeIndex'))->with("success", "Book Type updated successfully");
    }

    public function destroy(string $id)
    {
        $bookType = BookType::findOrFail($id);
        $bookType->delete();
        return redirect(route('bookTypeIndex'))->with("success", "Book Type deleted successfully");
    }
}
