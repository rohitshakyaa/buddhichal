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
        $chessBooks = ChessBook::select('id', 'image', 'name', 'type', 'file_path')
            ->get();
        foreach ($chessBooks as $chessBook) {
            $chessBook->file_path = url($chessBook->file_path);
            $chessBook->image = url($chessBook->image);
        }
        return ApiResponseHelper::successResponseWithData($chessBooks);
    }
}
