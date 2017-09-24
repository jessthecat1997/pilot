<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeAccidentsController extends Controller
{
  
    public function index()
    {
        
    }

  
    public function create(Request $request)
    {
        $provinces = \App\LocationProvince::all();
        $deliveries = \DB::table('delivery_receipt_headers')
        ->where('emp_id_driver', '=', $request->employee_id)
        ->get();
        $employee = \App\Employee::findOrFail($request->employee_id);

        return view('accident.accident_create', compact(['provinces','deliveries', 'employee']));

    }

   
    public function store(Request $request)
    {
        
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
