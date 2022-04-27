<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PreparedFood;
use App\Models\Ingredient;
use App\Models\Fridge;
use Illuminate\Validation\ValidationException;
class MakeFoodRequest extends FormRequest
{

    /** Collection */
    private $products;

    private $availables = [];

    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        // $this->products = Ingredient::where('food_id','=',$this->input('food_id'))->get();
      
        // $arr = [];
        // $this->products->each(function($product) use ($arr) {
        
        //     $arr['product'][$product->product_id] = $this->input('amount') * $product->portion;
        //     $available = Fridge::where('product_id', '=', $product->product_id)->first();

        //     if (!$available || $available->amount < $product->portion) {
        //         throw ValidationException::withMessages([
        //             'product.'.$product->product_id => 'Not enough products in your fridge'
        //         ]);
        //     }
           
        //     $this->availables[$product->product_id] = $available->amount;
        // });

        // $this->merge($arr);

    }
    public function rules()
    {
        $rules = [
            'food_id'=>'required|not_in:0',
            'amount'=>'required',
        ];

        foreach($this->availables as $key => $available) {
            $rules['product'][$key] ='required|lte:'.$available;
        }

        return $rules;
    }

  
    public function messages()
    {
        return [
            'food_id.required|not_in:0'=>'Please select a food',
            'amount.required'=>'Please insert amount!',
            
        ];
    }
}
