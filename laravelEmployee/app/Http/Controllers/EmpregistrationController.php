<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empregistration;

class EmpregistrationController extends Controller
{
    protected $employee;
    public function __construct(){
        $this->employee = new Empregistration();
    }

    public function index(){
        return $this->employee->all();
    }

    public function store(Request $request){
        return $this->employee->create($request->all());
    }

    public function update(Request $request, $id){
        $employee = $this->employee->find($id);
        $employee->update($request->all());
        return $employee;
    }

    public function destroy(string $id){
        $employee = $this->employee->find($id);
        return $employee->delete();
    }
}
