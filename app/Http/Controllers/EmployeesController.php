<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Http\Requests\StoreEmployee;

class EmployeesController extends Controller
{
    public function index()
    {

        return view('admin/utilities/employee_index');
    }


    public function store(StoreEmployee $request)
    {

        $employee = Employee::create($request->all());
        return $employee;
    }

    public function update(StoreEmployee $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->firstName = $request->firstName;
        $employee->middleName = $request->middleName;
        $employee->lastName = $request->lastName;
        
        $employee->save();

        return $employee;
    }


    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

    }

    public function reactivate(Request $request)
    {
        $employee = Employee::withTrashed()
        ->where('id',$request->id)
        ->restore();
        
    }

    public function employee_utilities(){

        return view('admin/utilities.employee_utility_index');
    }




}
