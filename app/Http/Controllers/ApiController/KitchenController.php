<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Fridge;
use App\Models\Food;
use App\Models\Unit;
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
            return response()->json(['Not enough products in your warehouse']);
        }
        }
           DB::commit();
           return response()->json(['Product has been moved to Fridge successfully']);
          
       }
       catch(\Exception $e){
           DB::rollBack();
           return response()->json(['error', $e->getMessage()]);
          
       }
        
    }
    public function getDays()
    {
        $dailys = Fridge::select(DB::raw('DATE(created_at)as date'), DB::raw('count(*) as total'))->groupBy('date')->get();

        return ['dailys' => $dailys];
    }
 
    public function getDateFromKitchen($day)
    {
        $kitchens = Fridge::whereDate('created_at',$day)->select('product_id',DB::raw('sum(amount) as total'))->groupBy('product_id')->with(['product','unit'])->get();
        $foods = Food::all();
       
        return ['kitchens'=>$kitchens,'foods'=>$foods];
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
        return response()->json(['Product has been returned successfully!']);
    }
        catch(\Exception $e){
        DB::rollBack();
        return response()->json(['error', $e->getMessage()]);
        }
    }
}
