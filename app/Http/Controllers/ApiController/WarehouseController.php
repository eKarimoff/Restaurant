<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Unit;
use App\Http\Requests\InsertProductRequest;
use Illuminate\Support\Facades\DB;
class WarehouseController extends Controller
{
    public function ombor(Request $request)
    {
        $products = Product::with(['warehouse', 'unit'])->orderBy('created_at')->paginate(5);
        $units = Unit::all();
        
        foreach($products as $product)
        {
            $product->warehouse->amount = $this->convertAmount($product->warehouse->amount);
        }
        return ['products'=>$products,'units'=>$units];
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
        
        DB::commit();
        return response()->json(['success', 'Product has been inserted successfully!']);
        
    }
        catch (\Exception $e) {
           return response()->json('error', $e->getMessage());
            DB::rollback();
        }  
    }

    public function editWarehouse($id=null)
    {
        $edit = Product::with('warehouse','unit')->find($id);
        return ['edit'=>$edit];
    }

    public function updateWare(Request $request,$id)
    {   
        
        $request->validate([
            'amount' => 'numeric|min:100'
        ]);
        
        $update = Warehouse::where('product_id', $id)->first();
        $update->amount += (int)$request['amount'];
        $update->save();
        return response()->json(['success','New Products added successfully']);
    }

    public static function convertAmount($data)
    {
        return $data / 1000;
    }
}
