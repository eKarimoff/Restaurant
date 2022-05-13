<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Table extends Model
{
    use HasFactory;

    protected $table = 'table';

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}
