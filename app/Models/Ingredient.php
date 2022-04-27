<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Food;
use App\Models\Product;
class Ingredient extends Model
{
    use HasFactory;
    protected $table = 'ingredients';

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public $timestamps = false;

    protected $appends = ['total_price'];

    public function getTotalPriceAttribute()
    {
        return $this->portion * $this->product->productPrice->price / 1000;
    }
}
