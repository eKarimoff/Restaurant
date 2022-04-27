<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Warehouse;
use App\Models\Unit;
use App\Models\Fridge;
use App\Models\Product_Price;
class Product extends Model
{
    use HasFactory;
    protected $table = 'Products';

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function fridge()
    {
        return $this->belongsTo(Fridge::class);
    }

    public function productPrice()
    {
        return $this->hasOne(Product_Price::class);
    }
    
  
  
}
