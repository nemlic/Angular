<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer; // Add this line at the top of the file


class CustomerController extends Controller
{
    public function adding(Request $request)
    {
        $request->validate([
            'id_number' => 'required',
            'firstName' => 'required',
            'surname' => 'required',
            'lastName' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        $items=new Customer();
        $items->id_number=$request->id_number;
        $items->firstName=$request->firstName;
        $items->surname=$request->surname;
        $items->lastName=$request->lastName;
        $items->phone=$request->phone;
        $items->email=$request->email;
        $items->save();
        return response()->json('Successfully Added');

}

public function edit(Request $request){
    $items=Customer::findorfail($request->id);
    $items->id_number=$request->id_number;
    $items->firstName=$request->firstName;
    $items->surname=$request->surname;
    $items->lastName=$request->lastName;
    $items->phone=$request->phone;
    $items->email=$request->email;
    $items->update();
    return response()->json('Successfully Updated');

} 

public function delete(Request $request){
    $items=Customer::findorfail($request->id)->delete();
    return response()->json('Successfully Deleted');
}
}