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

    public function show(Request $request, $id)
    {
        $incident = \App\EmployeeIncident::findOrFail($request->incident);
        $location = \DB::table('location_cities')
        ->select('a.name as province', 'location_cities.name as city')
        ->join('location_provinces as a', 'provinces_id', '=', 'a.id')
        ->where('location_cities.id', '=', $incident->cities_id)
        ->get();
        
        return view('incident.incident_view', compact(['incident', 'location']));
    }

    public function edit(Request $request, $id)
    {
        $provinces = \App\LocationProvince::all();
        $deliveries = \DB::table('delivery_receipt_headers')
        ->where('emp_id_driver', '=', $request->employee_id)
        ->get();
        $employee = \App\Employee::findOrFail($request->employee_id);
        $incident = \App\EmployeeIncident::findOrFail($request->incident);
        if($incident->cities_id == null){

        }
        else{
            $city = \App\LocationCities::findOrFail($incident->cities_id);
        }

        return view('incident.incident_edit', compact(['provinces','deliveries', 'employee', 'incident','city']));
    }

    public function update(Request $request, $id)
    {
        $edit_incident = \App\EmployeeIncident::findOrFail($request->incident);
        
        $edit_incident->incident_date = $request->incident_date;
        $edit_incident->incident_time = $request->incident_time;
        $edit_incident->date_opened = $request->date_opened;
        $edit_incident->date_closed = $request->date_closed;
        $edit_incident->address = $request->address;
        $edit_incident->cities_id = $request->cities_id;
        $edit_incident->delivery_id = $request->delivery_id;
        $edit_incident->fine = $request->fine;
        $edit_incident->description = $request->description;

        $edit_incident->save();

        return $edit_incident;   
    }

    public function destroy($id)
    {
        //
    }
}
