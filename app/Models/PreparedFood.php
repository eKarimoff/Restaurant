<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Food;
class PreparedFood extends Model
{
    use HasFactory;

    protected $table = 'prepared_foods';

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

}
