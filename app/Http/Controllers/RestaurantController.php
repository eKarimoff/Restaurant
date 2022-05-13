<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\Unit;
use App\Models\Order;
use App\Models\Warehouse;
use App\Models\Fridge;
use App\Models\PreparedFood;
use App\Models\Table;
use App\Rules\NotEnoughProducts;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Http\Requests\AddFoodRequest;
use Illuminate\Support\Facades\DB;


class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function menu(Request $request,$id = null)
    {
        
    if($request->search) {
        $foods = Food::with(['ingredients','preparedFood'])->where('name','like','%'.$request->search.'%')->orderBy('created_at')->paginate(5);
    }
    else {
        $foods = Food::with(['ingredients','preparedFood'])->orderBy('created_at')->paginate(5);
    }
    $products = Product::with('productPrice')->get();
    $foods->sum('total_price');
    return view('menu')->with(['foods' => $foods, 'products' => $products,]);
 
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

    session()->flash('Success', 'Food has been inserted successfully!');
    return redirect()->back();
    }

    catch (\Exception $e)
    {
        DB::rollback();
        session()->flash('danger', $e->getMessage());
        return redirect()->back();
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
            $order->count = $value;
            $order->save();
            $orders[] = [
                'food_name'=>$order->food->name,
                'food_price'=>$order->food->price,
                'count'=>$order->count
            ];
            
            $make = PreparedFood::where('food_id',$key)->first();
            if(!$make || $make->amount < $value)
            {
                session()->flash('warning','There are not enough foods or not available!');
                return redirect()->back();
            }
            
            else{
                $make->amount -= $value;
              
                $make->save();
            }
        }
        Mail::to(auth()->user())->send(new SendMail($orders));
 
        DB::commit();
        session()->flash('message', 'Order has been ordered successfully');
      
        return redirect()->back();
    }
        catch(\Exception $e){
            DB::rollback();
            session()->flash('danger', $e->getMessage());
            return redirect()->back();
        }
    }

    public function orderedFood()
    {
        $orders = Order::select('food_id', DB::raw('sum(count) as total'))->groupBy('food_id')->with('food')->orderBy('created_at')->paginate(5);
        return view('orders', compact('orders'));
    }

    public function editPrice($id)
    {
        $price = Food::find($id);
        
        return view('editPrice')->with(['price'=>$price]);
    }

    public function updateFoodPrice(Request $request,$id)
    {
        $update = Food::where('id', $id)->first();
        $update->price = $request->price;
        $update->save();
        dispatch(new SendEmail());
        session()->flash('success','Price has been updated successfully!');
        return redirect()->back();
    }

    public function tables()
    {
        $tables = Table::all();

        return view('table',compact('tables'));
    }

    public function booking($id = null)
    {
        $this->menu($request);
        return redirect()->route('menu');
    }


}
