<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;

class RegistrationController extends Controller
{
    protected $reg;
    public function __construct(){
        $this->reg=new Registration();
    }

    public function index(){
        return $this->reg->all();
    }

    public function store(Request $request){
        return $this->reg->create($request->all());
    }

    public function show(string $id){
        return $reg=$this->reg->find($id);
    }

    public function update(Request $request, string $id){
        $reg=$this->reg->find($id);
        $reg->update($request->all());
        return $reg;
    } 

    public function destroy(string $id){
        $reg=$this->reg->find($id);
        return $reg->delete();
    }

}
 