<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Price;
class warehouse extends Model
{
    use HasFactory;
    protected $table = 'warehouses';

    public function product()
    {
        return $this->belongTo(Product::class);
    }

}
