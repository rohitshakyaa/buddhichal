<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponseHelper;
use App\Models\ChessBook;
use Illuminate\Http\Request;

class ChessBookApiAdminController extends Controller
{
    public function index()
    {
        $chessBooks = ChessBook::all();
        foreach ($chessBooks as $chessBook) {
            $chessBook->image = url($chessBook->image);
            $chessBook->book_file = url($chessBook->book_file);
        }
        return ApiResponseHelper::successResponseWithData($chessBooks);
    }
}
