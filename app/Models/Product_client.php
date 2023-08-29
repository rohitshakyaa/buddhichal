<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_client extends Model
{
    use HasFactory;

    protected $guarded = [''];


    public function product_clients()
    {
        return $this->hasMany(Product_client::class);
    }
}
