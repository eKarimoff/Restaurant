<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fridge;
use App\Models\Warehouse;
use App\Models\Food;
use App\Rules\NotEnoughProducts;
use Illuminate\Support\Facades\DB;
class KitchenController extends Controller
{
    public function storeToFridge(Request $request)
    {
        DB::beginTransaction();
        $data = $request->all();
       
       try{

           foreach($data['name'] as $key => $value){
            $store = Fridge::where('product_id',$key)->first();
            if(!$store){
                $store = new Fridge();
            }
                $store->product_id = $key;
                $store->amount += $value;
                $store->save();
            
            $warehouse = Warehouse::where('product_id', $key)->first();
            if($warehouse->amount > $value){

            $warehouse->amount -= $value;
            $warehouse->save();
        }
        else{
            session()->flash('warning','Not enough products in your warehouse');
            return redirect()->back();
        }
        }
           DB::commit();
           session()->flash('message', 'Product has been moved to Fridge successfully');
           return redirect()->back();
       }
       catch(\Exception $e){
           DB::rollBack();
           session()->flash('danger', $e->getMessage());
           return redirect()->back();
       }
        
    }
    public function getDays()
    {
        $dailys = Fridge::select(DB::raw('DATE(created_at)as date'), DB::raw('count(*) as total'))->groupBy('date')->get();

        return view('fridge', compact('dailys'));
    }
 
    public function getDateFromKitchen($day)
    {
        $kitchens = Fridge::whereDate('created_at',$day)->select('product_id',DB::raw('sum(amount) as total'))->groupBy('product_id')->with(['product','unit'])->get();
        $foods = Food::all();
        return view('makeFood', compact('kitchens','foods'));
    }

    public function returnProduct(Request $request)
    {
    DB::beginTransaction();

    $data = $request->all();
      
    try{
        foreach($data['name'] as $key => $value){
        $return = Warehouse::find($key);
            $return->amount += $value;
            $return->save();
        
            $remove = Fridge::where('product_id', $key)->first();
            if($remove->amount == $value)
            {
                $remove->delete();
            }
            else{
                $remove->amount -= $value;
                $remove->save();
            }
        
        }
        DB::commit();
        session()->flash('success', 'Product has been returned successfully!');
        return redirect()->back();
    }
        catch(\Exception $e){
        DB::rollBack();
        session()->flash('danger', $e->getMessage());
        return redirect()->back();
        }
    }

    
}
