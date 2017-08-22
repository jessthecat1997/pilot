<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeeType;
use App\Http\Requests\StoreEmployeeType;

class EmployeeTypesController extends Controller
{
    public function index()
    {
        return view('admin/utilities.employee_type_index');
    }


    public function store(StoreEmployeeType $request)
    {

        $et = EmployeeType::create($request->all());
        return $et;
    }

    public function update(StoreEmployeeType $request, $id)
    {
        $employee_type = EmployeeType::findOrFail($id);
        $employee_type->name = $request->name;
        $employee_type->description = $request->description;
        $employee_type->save();

        return $employee_type;
    }


    public function destroy($id)
    {
        $employee_type = EmployeeType::findOrFail($id);
        $employee_type->delete();

    }


    public function reactivate(Request $request)
    {
        $employee_type = EmployeeType::withTrashed()
        ->where('id',$request->id)
        ->restore();
        
    }

    public function employee_type_utilities(){

        return view('admin/utilities.employee_type_utility_index');
    }
}
