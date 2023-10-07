<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Http\Helpers\Constant;
use App\Models\ChessBook;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ChessBookApiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('type')) {
            if (!in_array($request->type, Constant::$bookTypes)) {
                throw ValidationException::withMessages(["type" => "Invalid type. Accepted types: " . implode(", ", Constant::$bookTypes)]);
            }
        }

        $chessBooks = ChessBook::select('id', 'name', 'type', 'image', 'book_file')
            ->when($request->has('type'), function ($query) use ($request) {
                return $query->where('type', $request->type);
            })
            ->get();

        $chessBooks->each(function ($chessBook) {
            $chessBook->image = url($chessBook->image);
            $chessBook->book_file = url($chessBook->book_file);
        });

        return ApiResponseHelper::successResponseWithData($chessBooks);
    }
}
