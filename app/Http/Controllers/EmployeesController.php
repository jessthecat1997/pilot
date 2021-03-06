<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeRole;
use App\EmployeeDetails;
use App\Http\Requests\StoreEmployee;
use App\User;

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
        $employee->emp_pic = $request->emp_pic;
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

        $user = DB::table('users')
        ->join('employees', 'users.emp_id', '=', 'employees.id')
        ->select('users.id')
        ->where('users.emp_id', '=', $id)
        ->get();

        return view('employee.employees_edit', compact(['employee', 'provinces', 'employee_role', 'location', 'user']));
    }


    public function update(StoreEmployee $request, $id)
    {

        $employee = Employee::findOrFail($id);
        $employee->emp_pic = $request->emp_pic;
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

        $emp_roles = DB::table('employee_roles')->where('employee_id', '=', $employee_id)->get();

        $employee_incidents = \DB::table('employee_incidents')
        ->where('employees_id', '=', $employee->id)
        ->get();

        $role = DB::table('employee_roles')
        ->join('employee_types', 'employee_roles.employee_type_id', '=', 'employee_types.id')
        ->select('employee_types.id')
        ->where('employee_id', '=', $employee_id)->get();

        $employee_accidents = \DB::table('employee_accidents')
        ->where('employees_id', '=', $employee->id)
        ->get();

        $location = DB::table('location_cities')
        ->join('location_provinces as A', 'provinces_id', '=', 'A.id')
        ->select('location_cities.name as city', 'A.name as province')
        ->where('location_cities.id', '=', $employee->cities_id)
        ->get();

        $user = DB::table('users')
        ->select('id','email', 'password')
        ->where('emp_id', '=', $employee->id)
        ->get();
        

        return view('employee/employee_view', compact(['employee_id', 'employee', 'location', 'employee_role', 'employee_accidents', 'employee_incidents', 'emp_roles', 'role', 'user']));
    }

    catch(ModelNotFoundException $e)
    {
        return 'No service order';
    }
}
public function store_user(Request $request)
{
    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->emp_pic = $request->emp_pic;
    $user->emp_id = $request->emp_id;
    $user->role_id = $request->role_id;
    $user->save();
}
public function updateUser(Request $request)
{
    $user = User::findOrFail($request->user_id);
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->save();

    return $user;
}
public function updateUserPic(Request $request)
{
    $user = User::findOrFail($request->user_id);
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->save();

    return $user;
}
}
