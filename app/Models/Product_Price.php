<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class Product_Price extends Model
{
    use HasFactory;

    protected $table = 'product_prices';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
