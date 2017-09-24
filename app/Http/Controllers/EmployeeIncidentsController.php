<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeIncidentsController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $provinces = \App\LocationProvince::all();
        $deliveries = \DB::table('delivery_receipt_headers')
        ->where('emp_id_driver', '=', $request->employee_id)
        ->get();
        $employee = \App\Employee::findOrFail($request->employee_id);

        return view('incident.incident_create', compact(['provinces','deliveries', 'employee']));
    }

    public function store(Request $request)
    {
        $new_incident = new \App\EmployeeIncident;
        $new_incident->employees_id = $request->employees_id;
        $new_incident->incident_date = $request->incident_date;
        $new_incident->incident_time = $request->incident_time;
        $new_incident->date_opened = $request->date_opened;
        $new_incident->date_closed = $request->date_closed;
        $new_incident->address = $request->address;
        $new_incident->cities_id = $request->cities_id;
        $new_incident->delivery_id = $request->delivery_id;
        $new_incident->fine = $request->fine;
        $new_incident->description = $request->description;

        $new_incident->save();

        return $new_incident;   
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
