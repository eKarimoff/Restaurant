<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fridge;
use App\Models\PreparedFood;
use App\Models\Ingredient;
use App\Models\Warehouse;
use App\Http\Requests\MakeFoodRequest;

use Illuminate\Support\Facades\DB;
class PreparedFoodController extends Controller
{
    public function readyFood()
    {
        $getFoods = PreparedFood::with('food')->orderBy('created_at')->paginate(5);
        
        return view('readyFood',compact('getFoods'));
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
            else
            {
                $make->food_id = $cook['food_id'];
                $make->amount += $cook['amount'];
                $make->save();
            }
            $ingredients = Ingredient::where('food_id',$cook['food_id'])->get();
            foreach($ingredients as $ingredient){
                $data = Fridge::where('product_id',$ingredient->product_id)->first();
                if(!$data || $data->amount < $ingredient->portion)
                {
                    session()->flash('error','Some products are not enough in your fridge please take from here');
                    return redirect()->route('warehouse');
                }
                $data->amount -= $ingredient->portion * $cook['amount'];
                $data->save();
            }
            DB::commit();
            session()->flash('success','Your food has been made successfully!');
            return redirect()->back();
        }

        catch(\Exception $e){
            DB::rollBack();
            session()->flash('danger',$e->getMessage());
            return redirect()->back();
        }
    }
 

}
