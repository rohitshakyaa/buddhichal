<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function product_client()
    {
        return $this->belongsTo(ProductClient::class);
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
