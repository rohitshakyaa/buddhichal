<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Constant;
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
        return view('pages.books.create', ["types" => Constant::$bookTypes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => ['required', Rule::in(Constant::$bookTypes)],
            'image' => 'required|image|mimes:jpg,jpeg,png|max:3062',
            'book_file' => 'required|mimes:pdf|max:3062',
        ]);

        DB::beginTransaction();
        try {
            Log::info('parameters for adding chess book', $request->all());
            $chessBook = new ChessBook;
            $chessBook->name = $request->name;
            $chessBook->type = $request->type;
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
        $types = Constant::$bookTypes;
        return view('pages.books.edit', compact('book', 'types'));
    }


    public function update(Request $request, $id)
    {
        $chessBook = ChessBook::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'type' => ['required', Rule::in(Constant::$bookTypes)],
            'image' => 'image|mimes:jpg,jpeg,png|max:3062',
            'book_file' => 'mimes:pdf|max:3062',
        ]);

        DB::beginTransaction();
        try {
            Log::info('parameters for updating chess book', $request->all());
            $chessBook->name = $request->name;
            $chessBook->type = $request->type;
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
<<<<<<< HEAD
            Log::info("Data updated for chess books with values: ", $chessBook->toArray());
=======
            Log::info("Data saved for chessbooks with values: ", $chessBook->toArray());
>>>>>>> 737a96a889f8d51b71db15d5a042e4e84fcaa509
            DB::commit();
            return redirect(route('bookIndex'))->with('success', 'ChessBook updated successfully');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return back()
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
