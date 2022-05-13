<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\PreparedFood;
class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function preparedFood()
    {
        return $this->hasOne(PreparedFood::class);
    }
        
    public function getMadePriceAttribute()
    {
        return $this->ingredients->sum('total_price');
    }
    

    

  
}
