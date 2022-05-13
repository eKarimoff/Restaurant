<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Food;
use App\Models\Table;
class Order extends Model
{
    use HasFactory;
    protected $table = 'Orders';

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public $timestamps = false;
}
