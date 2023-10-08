<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Http\Helpers\Constant;
use App\Models\BookType;
use App\Models\ChessBook;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ChessBookApiController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "type_id" => "exists:book_types,id"
        ]);


        $chessBooks = ChessBook::with(['book_type' => function ($query) {
            $query->select('id', 'title');
        }])->select('id', 'name', 'image', 'book_file', 'book_type_id')
            ->when($request->has('type_id'), function ($query) use ($request) {
                return $query->where('book_type_id', $request->type_id);
            })
            ->get();

        $chessBooks->each(function ($chessBook) {
            $chessBook->image = url($chessBook->image);
            $chessBook->book_file = url($chessBook->book_file);
            $chessBook->type = $chessBook->book_type->title;
            unset($chessBook->book_type_id);
            unset($chessBook->book_type);
        });

        return ApiResponseHelper::successResponseWithData($chessBooks);
    }
}
