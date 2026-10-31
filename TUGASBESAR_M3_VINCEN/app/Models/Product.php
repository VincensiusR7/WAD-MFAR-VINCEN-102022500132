<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   //menghubungkan ke tabel di database
   protected $table="product"


    public $timestamps = false;

    protected $fillable = [
        'name',
        'product_condition',
        'price',
        'size',
        'image',
        'likes',
        'stock',
    ];
}
