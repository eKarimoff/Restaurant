<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Ingredient;
use Illuminate\Support\Facades\DB;
class DetailController extends Controller
{
    public function orderDetail($id=null)
    {
        $detail = Order::where('food_id', $id)->with('food')->orderBy('created_at')->paginate(8);

        return ['detail'=>$detail];
    }
    public function statistic()
    {
        $statistic = Order::select('food_id', DB::raw('sum(count) as total'))->groupBy('food_id')->with('food')->get();

        return ['statistic'=>$statistic];
    }
    public function ingredient($id=null)
    {
        $details = Ingredient::with(['food','product'])->where('food_id',$id)->get();
        
        return ['details'=>$details];
    }
}
