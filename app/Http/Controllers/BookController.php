<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Constant;
use App\Models\BookType;
use App\Models\ChessBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Throwable;

class BookController extends Controller
{
    public function index()
    {
        return view('pages.books.index');
    }

    public function create()
    {
        $types = BookType::select(["id", "title"])->get();
        return view('pages.books.create', compact('types'));
    }

    public function store(Request $request)
    {
        Log::info('parameters for adding chess book', $request->all());
        $request->validate([
            'name' => 'required',
            'type_id' => 'required|exists:book_types,id',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:3062',
            'book_file' => 'required|mimes:pdf|max:3062',
        ]);

        DB::beginTransaction();
        try {
            $chessBook = new ChessBook;
            $chessBook->name = $request->name;
            $chessBook->book_type_id = $request->type_id;
            $chessBook->image = "";
            $chessBook->book_file = "";
            $chessBook->save();

            if ($request->hasFile('image')) {
                $chessBook->image = $this->storeBookImage($chessBook->id, $request->file('image'));
            }

            if ($request->hasFile('book_file')) {
                $chessBook->book_file = $this->storeBookFile($chessBook->id, $request->file('book_file'));
            }
            $chessBook->save();
            Log::info("Data saved for chess books with values: ", $chessBook->toArray());
            DB::commit();
            return redirect(route('bookIndex'))->with('success', 'Chess Book added successfully');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput($request->input())
                ->with('danger', 'something went wrong');
        }
    }

    public function edit(Request $request, string $id)
    {
        $book = ChessBook::findOrFail($id);
        $book->image = url($book->image);
        $book->book_file = url($book->book_file);
        $types = BookType::select(["id", "title"])->get();
        return view('pages.books.edit', compact('book', 'types'));
    }


    public function update(Request $request, $id)
    {
        Log::info('parameters for updating chess book', $request->all());
        $chessBook = ChessBook::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'type_id' => 'required|exists:book_types,id',
            'image' => 'image|mimes:jpg,jpeg,png|max:3062',
            'book_file' => 'mimes:pdf|max:3062',
        ]);


        DB::beginTransaction();
        try {
            $chessBook->name = $request->name;
            $chessBook->book_type_id = $request->type_id;
            $chessBook->save();

            if ($request->hasFile('image')) {
                File::delete(public_path($chessBook->image));
                $chessBook->image = $this->storeBookImage($chessBook->id, $request->file('image'));
            }

            if ($request->hasFile('book_file')) {
                File::delete(public_path($chessBook->book_file));
                $chessBook->book_file = $this->storeBookFile($chessBook->id, $request->file('book_file'));
            }
            $chessBook->save();
            Log::info("Data updated for chess books with values: ", $chessBook->toArray());
            DB::commit();
            return redirect(route('bookIndex'))->with('success', 'Chess Book updated successfully');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput($request->input())
                ->with('danger', 'something went wrong');
        }
    }

    public function destroy($id)
    {
        $chessBook = ChessBook::findOrFail($id);
        $chessBook->delete();
        return back()->with("success", "Book deleted successfully");
    }

    private function storeBookImage($bookId, $imageFile)
    {
        $imagePath = "images/books/";
        $path = public_path($imagePath);
        $imageName = $bookId . '-' . time() . '.' . $imageFile->extension();
        $imageFile->move($path, $imageName);
        return $imagePath . '/' . $imageName;
    }

    private function storeBookFile($bookId, $imageFile)
    {
        $imagePath = "pdfs/books/";
        $path = public_path($imagePath);
        $imageName = $bookId . '-' . time() . '.' . $imageFile->extension();
        $imageFile->move($path, $imageName);
        return $imagePath . '/' . $imageName;
    }
}
