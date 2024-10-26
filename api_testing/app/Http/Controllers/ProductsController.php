<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;

class ProductsController extends Controller
{
    public function adding(Request $request)
    {
        $items=new products();
        $items->name=$request->name;
        $items->manufacture=$request->manufacture;
        $items->quantity=$request->quantity;
        $items->save();
        return response()->json('Successfully Added');

    }
    public function getData()
    {
        $products = products::all();
        return response()->json($products);
    }
    public function edit(request $request){
        $items=products::findorfail($request->id);
        $items->name=$request->name;
        $items->manufacture=$request->manufacture;
        $items->quantity=$request->quantity;
 
        $items->update();
 
        return response()->json('Successfully Updated');
 
    }
    public function delete(request $request){
        $items=products::findorfail($request->id)->delete();
        return response()->json('Successfully Deleted');
 
    }
}
