<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chess_book extends Model
{
    use HasFactory;

    public function book_type()
    {
        return $this->belongsTo(Book_type::class);
    }

    
    
}
