<?php

namespace App\Http\Controllers;

use App\Models\ChessBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BookController extends Controller
{
    public function index()
    {
        return view('pages.book.index');
    }

    public function create()
    {
        return view('pages.book.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'name' => 'required',
            'type' => 'required',
            'file_path' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Log::info('parameters for adding chess book', $request->all());
            $chessBook = new ChessBook;
            $chessBook->name = $request->name;
            $chessBook->type = $request->type;
            $chessBook->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = 'public/images';
                $path = public_path($imagePath);
                $imageName = $chessBook->id . '-' . now()->format('YmdHis') . '.' . $image->extension();
                $image->move($path, $imageName);
                $chessBook->image = $imagePath . '/' . $imageName;
                $chessBook->save();
            }

            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $filePath = 'public/pdf';
                $path = public_path($filePath);
                $fileName = $chessBook->name . '-' . now()->format('YmdHis') . '-' . $file->extension();
                $chessBook->file = $filePath . '/' . $fileName;
                $chessBook->save();
            }
            Log::info("Data saved for chess books with values: ", $chessBook->toArray());
            DB::commit();
            return redirect(route('chessBookIndex'))->with('success', 'ChessBook added successfully');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->with('danger', 'something went wrong');
        }
    }

    public function edit(Request $request, string $id)
    {
        $chessBook = ChessBook::findOrFail($id);
        return view('pages.book.edit', compact('chessBook'));
    }


    public function update(Request $request, $id)
    {
        $chessBook = ChessBook::findOrFail($id);
        $request->validate([
            'image' => 'required',
            'name' => 'required',
            'type' => 'required',
            'file_path' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Log::info('parameters for updating chess book', $request->all());
            $chessBook->name = $request->name;
            $chessBook->type = $request->type;
            $chessBook->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = 'public/images';
                $path = public_path($imagePath);
                $imageName = $chessBook->id . '-' . now()->format('YmdHis') . '.' . $image->extension();
                $image->move($path, $imageName);
                $chessBook->image = $imagePath . '/' . $imageName;
                $chessBook->save();
            }

            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $filePath = 'public/pdfs';
                $path = public_path($filePath);
                $fileName = $chessBook->name . '-' . now()->format('YmdHis') . '-' . $file->extension();
                $chessBook->file = $filePath . '/' . $fileName;
                $chessBook->save();
            }
            Log::info("Data updated for chess books with values: ", $chessBook->toArray());
            DB::commit();
            return redirect(route('chessBookIndex'))->with('success', 'ChessBook updated successfully');
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
        return redirect(route('bookIndex'))
            ->with('success', 'a book deleted successfully');
    }
}
