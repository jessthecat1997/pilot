<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeType;
use App\EmployeeRole;

class EmployeeRolesController extends Controller
{
    public function index(Request $request)
    {
        $data = Employee::findOrFail($request->employee);
        $employee_id = $request->employee;
        $employee_types = EmployeeType::all();
        return view('admin/utilities/employee_role_index', compact(['employee_id', 'employee_types', 'data']));
    }


    public function store(Request $request)
    {

        $employee_role = EmployeeRole::create($request->all());
        return $employee_role;
    }

    public function destroy(Request $request)
    {
        $employee_role = EmployeeRole::findOrFail($request->view);
        $employee_role->delete();
    }
}
