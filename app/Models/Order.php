<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Food;
class Order extends Model
{
    use HasFactory;
    protected $table = 'Orders';

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public $timestamps = false;
}
