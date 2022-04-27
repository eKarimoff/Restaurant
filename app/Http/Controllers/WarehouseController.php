<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Models\Price;
use App\Http\Requests\InsertProductRequest;
use Illuminate\Support\Facades\DB;
class WarehouseController extends Controller
{
    public function ombor(Request $request)
    {
        $products = Product::with(['warehouse', 'unit','productPrice'])->orderBy('created_at')->paginate(5);
        $units = Unit::all();
        
        foreach($products as $product)
        {
            $product->warehouse->amount = $this->convertAmount($product->warehouse->amount);
        }
      
        return view('warehouse', compact('products', 'units'));
    }
   
    public function InsertProduct(InsertProductRequest $request)
    {
        DB::beginTransaction();
        
        $data = $request->all();
        try {
            $product = new Product();
            $product->name = $data['name'];
            $product->unit_id = $data['unit_id'];
            $product->save();

            $warehouse = new Warehouse();
            $warehouse->product_id = $product->id;
            $warehouse->amount = $data['amount'];
            $warehouse->save();

            $price = new Price();
            $price->product_id = $product->id;
            $price->price = $data['price'];
            $price->save();
        
        DB::commit();
        session()->flash('success', 'Product has been inserted successfully!');
        return redirect()->back();
    }
        catch (\Exception $e) {
            session()->flash('danger', $e->getMessage());
            DB::rollback();
            return redirect()->back();
        }  
    }

    public function editWare($id)
    {
        $edit = Product::with('warehouse')->find($id);
        return view('editWare', compact('edit'));
    }

    public function updateWare(Request $request,$id)
    {   
        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);
        $update = Warehouse::where('product_id', $id)->first();
        $update->amount += (int)$request['amount'];
        $update->save();
        $price = new Price();
        $price->product_id = $id;
        $price->price = $request['price'];
        $price->save();
        
        session()->flash('message','Product has been added successfully!');
        return redirect()->back();
    }

    public static function convertAmount($data)
    {
        return $data / 1000;
    }

}
