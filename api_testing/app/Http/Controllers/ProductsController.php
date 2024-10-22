<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    public function adding(Request $request)
    {
        $items=new Products();
        $items->name=$request->name;
        $items->manufacture=$request->manufacture;
        $items->quantity=$request->quantity;
        $items->save();
        return response()->json('Successfully Added');

    }
    public function get(Request $request)
    {
        $products = Product::all();
        return response()->json($products);
    }
}
