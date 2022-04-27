<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Warehouse;
use App\Models\PreparedFood;
use App\Http\Requests\AddFoodRequest;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function menu()
    {
    $foods = Food::with(['ingredients','preparedFood'])->orderBy('created_at')->paginate(5);
    $products = Product::all();
    $total = $foods->sum('total_price');
    return ['foods' => $foods, 'products' => $products,'total' => $total];
    }

    public function addFood(AddFoodRequest $request)
    { 
       DB::beginTransaction();
        try{
        $data = $request->all();
        $food = new Food();
        $food->name = $data['name'];
        $food->save();
            
        foreach($data['form'] as $key => $value){
        $inside = new Ingredient();
            
        $inside->product_id = $value['product_id'];
        $inside->food_id = $food->id;
        $inside->portion = $value['portion'];
        $inside->save();
    }
    DB::commit();

    return response()->json(['Food has been inserted successfully!']);

    }

    catch (\Exception $e)
    {
        DB::rollback();
        return response()->json(['error', $e->getMessage()]);
        
    }
}
    public function orderStore(Request $request)
    {   
        $request->validate([
        'name'=> 'required',
    ]);
        DB::beginTransaction();
        $data = $request->all();
      
        try{
            foreach($data['name'] as $key=>$value){
            $order = new Order();
            $order->food_id = $key;
            $order->count = $value ? $value : 1;
            $order->save();

            $make = PreparedFood::where('food_id',$key)->first();
            if(!$make || $make->amount < $value)
            {
               return response()->json(['You do not have enough foods as you ordered']);
           
            }
            $make->amount -= $value;
            $make->save();
        }
 
        DB::commit();
        return response()->json(['message', 'Order has been ordered successfully']);
    
    }
        catch(\Exception $e){
            DB::rollback();
           return response()->json(['error', $e->getMessage()]);
      
        }
    }

    public function orderedFood()
    {
        $orders = Order::select('food_id', DB::raw('sum(count) as total'))->groupBy('food_id')->with('food')->orderBy('created_at')->paginate(5);

        return ['orders'=>$orders];
    }
}
