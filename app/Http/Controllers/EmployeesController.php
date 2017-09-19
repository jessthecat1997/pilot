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
        
        return view('employee.employees_edit', compact(['employee', 'provinces', 'employee_role']));
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

    public function view_employee(Request $request){
      try
      {
        $employee_id = $request->employee_id;

        $employees = DB::table('employees')
        ->select('employees.id', 'firstName', 'middleName', 'lastName')
        ->where('employees.id','=', $employee_id)
        ->get();


        $employee_details = DB::table('employees')
        ->select('employee_details.id', 'employees_id', 'address', 'age', 'phoneContact' ,'cellphoneContact', 'cities_id', 'dateOfBirth', 'emergencyContact', 'socialSecurityNumber', 'inCaseOfEmergency', 'zipCode', 'location_cities.name AS city', 'location_provinces.name AS province' )
        ->join('location_cities', 'cities_id', '=', 'location_cities.id')
        ->join('location_provinces', 'provinces_id', '=', 'location_provinces.id')
        ->where('employees_id','=', $employee_id)
        ->get();

        $employee_roles = DB::table('employee_roles')
        ->select('employee_roles.id', 'employee_id', 'employee_type_id', 'name')
        ->join('employee_types', 'employee_type_id', '=', 'employee_types.id')
        ->where('employee_id', '=', $employee_id)
        ->get();


    }
    catch(ModelNotFoundException $e)
    {
      return 'No service order';
  }

  return view('employee/employee_view', compact(['employee_id', 'employees', 'employee_details', 'employee_roles']));
}
}
