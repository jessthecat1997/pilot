<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeRole;
use App\EmployeeDetails;
use App\Http\Requests\StoreEmployee;

use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    public function index()
    {
        return view('employee/employees_index');
    }

    public function create(){

        $employee_role = DB::table('employee_types')
        ->select('id', 'name')
        ->get();

        $provinces = DB::table('location_provinces')
        ->select('name', 'id')
        ->where('deleted_at', '=', null)
        ->get();

        return view('employee/employees_create', compact(['employee_role', 'provinces']));
    }

    public function store(Request $request)
    {

        $employee = new Employee;
        $employee->firstName = $request->firstName;
        $employee->middleName = $request->middleName;
        $employee->lastName = $request->lastName;
        $employee->dob = $request->dob;
        $employee->address = $request->address;
        $employee->zipCode = $request->zipCode;
        $employee->cities_id = $request->cities_id;
        $employee->SSSNo = $request->SSSNo;
        $employee->contactNumber = $request->contactNumber;
        $employee->inCaseOfEmergency = $request->inCaseOfEmergency;
        $employee->save();


        $_employee_types =  json_decode(stripslashes($request->toggles), true);

        for($x = 0; $x < count($_employee_types); $x++ )
        {
            $employee_roles = new EmployeeRole;
            $employee_roles->employee_id = $employees_id = $employee->id;
            $employee_roles->employee_type_id = $_employee_types[$x];
            $employee_roles->save();
        }

        $employee_id = $employee->id;

        return $employee_id;

    }

    public function edit(Request $request, $id)
    {
        $provinces = \App\LocationProvince::all();

        $employee_role = \App\EmployeeType::all();

        $employee = Employee::findOrFail($id);

        $location = $employee->cities_id;
        
        return view('employee.employees_edit', compact(['employee', 'provinces', 'employee_role', 'location']));
    }


    public function update(StoreEmployee $request, $id)
    {

        $employee = Employee::findOrFail($id);
        $employee->firstName = $request->firstName;
        $employee->middleName = $request->middleName;
        $employee->lastName = $request->lastName;
        $employee->dob = $request->dob;
        $employee->address = $request->dob;
        $employee->zipCode = $request->zipCode;
        $employee->cities_id = $request->cities_id;
        $employee->SSSNo = $request->SSSNo;
        $employee->contactNumber = $request->contactNumber;
        $employee->inCaseOfEmergency = $request->inCaseOfEmergency;

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

    public function view_employee(Request $request){
      try
      {
        $employee_id = $request->employee_id;

        $employee = \App\Employee::findOrFail($employee_id);

        $employee_role = \App\EmployeeType::all();

        $employee_incidents = \DB::table('employee_incidents')
        ->where('employees_id', '=', $employee->id)
        ->get();

        $employee_accidents = \DB::table('employee_accidents')
        ->where('employees_id', '=', $employee->id)
        ->get();

        $location = DB::table('location_cities')
        ->join('location_provinces as A', 'provinces_id', '=', 'A.id')
        ->select('location_cities.name as city', 'A.name as province')
        ->where('location_cities.id', '=', $employee->cities_id)
        ->get();
        

        return view('employee/employee_view', compact(['employee_id', 'employee', 'location', 'employee_role', 'employee_accidents', 'employee_incidents']));
    }

    catch(ModelNotFoundException $e)
    {
        return 'No service order';
    }
}
}
