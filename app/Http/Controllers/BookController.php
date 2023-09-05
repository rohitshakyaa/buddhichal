<?php

namespace App\Http\Controllers;

use App\Models\Book_type;
use App\Models\Chess_book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    /**
     * @param $id is interger type id of book_type 
     */
    public function getBookByType($id)
    {
        $book = Book_type::findOrFail($id);
        if($book)
        {
            $book = Chess_book::whereHas('book_type', function($query) use($id){
                $query->where('id', $id);
            })->get(); 
        }
    }
   
}
