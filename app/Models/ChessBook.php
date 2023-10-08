<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChessBook extends Model
{
    use HasFactory;

    protected $table = 'chess_books';

    public function book_type()
    {
        return $this->belongsTo(BookType::class);
    }
}
