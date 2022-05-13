<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Food;
use Illuminate\Support\Facades\DB;
class DetailController extends Controller
{
    public function orderDeatil($id)
    {
        $orderDetail = Order::where('food_id', $id)->with('food')->orderBy('created_at')->paginate(8);

        return view('orderDetail',compact('orderDetail'));
    }
    public function statistic()
    {
        $statistic = Order::select('food_id', DB::raw('sum(count) as total'))->groupBy('food_id')->with('food')->get();

        return view('statistic', compact('statistic'));
    }
    public function ingredient(Request $request,$id)
    {
        $details = Ingredient::with(['food','product'])->where('food_id',$id)->get();
        $total = $details->sum('total_price');

        return view('ingredient')->with(['total'=>$total,'details'=>$details]);
    }

    
}