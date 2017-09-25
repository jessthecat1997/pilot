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
        $new_accident = new \App\EmployeeAccident;
        $new_accident->employees_id = $request->employees_id;
        $new_accident->incident_date = $request->incident_date;
        $new_accident->incident_time = $request->incident_time;
        $new_accident->date_opened = $request->date_opened;
        $new_accident->date_closed = $request->date_closed;
        $new_accident->address = $request->address;
        $new_accident->cities_id = $request->cities_id;
        $new_accident->delivery_id = $request->delivery_id;
        $new_accident->numberOfInjuries = $request->numberOfInjuries;
        $new_accident->numberOfFatalities = $request->numberOfFatalities;
        $new_accident->propertyDamage = $request->propertyDamage;
        $new_accident->description = $request->description;

        $new_accident->save();

        return $new_accident;
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
