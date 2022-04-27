<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fridge;
use App\Models\PreparedFood;
use App\Models\Ingredient;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MakeFoodRequest;
class PreparedFoodController extends Controller
{
    public function makeFood()
    {
        $getFoods = PreparedFood::with('food')->get();
        
        return ['getFoods'=>$getFoods];
    }
    public function cookFood(MakeFoodRequest $request)
    {
        DB::beginTransaction();
        $cook = $request->all();
        try{
            $make = PreparedFood::where('food_id',$cook['food_id'])->first();
            if(!$make){
                $make = new PreparedFood();
                $make->food_id = $cook['food_id'];
                $make->amount = $cook['amount'];
                $make->save();
            }
            else{
                $make->food_id = $cook['food_id'];
                $make->amount += $cook['amount'];
                $make->save();
            }
            
            $ingredients = Ingredient::where('food_id',$cook['food_id'])->get();
            foreach($ingredients as $ingredient){
                $data = Fridge::where('product_id',$ingredient->product_id)->first();
                if(!$data || $data->amount < $ingredient->portion){
                    return response()->json(['Not enough products in your fridge!']);
                }
                else{
                    $data->amount -= $ingredient->portion * $cook['amount'];
                }
                $data->save();
            }
            DB::commit();
            return response()->json(['Your food has been made successfully!']);
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error',$e->getMessage()]);
          
        }
    }
}
