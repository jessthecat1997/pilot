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

    
    public function show(Request $request, $id)
    {
        $accident = \App\EmployeeAccident::findOrFail($request->accident);
        $location = \DB::table('location_cities')
        ->select('a.name as province', 'location_cities.name as city')
        ->join('location_provinces as a', 'provinces_id', '=', 'a.id')
        ->where('location_cities.id', '=', $accident->cities_id)
        ->get();
        
        return view('accident.accident_view', compact(['accident', 'location']));
    }

    
    public function edit(Request $request, $id)
    {
        $provinces = \App\LocationProvince::all();
        $deliveries = \DB::table('delivery_receipt_headers')
        ->where('emp_id_driver', '=', $request->employee_id)
        ->get();
        $employee = \App\Employee::findOrFail($request->employee_id);
        $accident = \App\EmployeeAccident::findOrFail($request->accident);
        if($accident->cities_id == null){

        }
        else{
            $city = \App\LocationCities::findOrFail($accident->cities_id);
        }

        return view('accident.accident_edit', compact(['provinces','deliveries', 'employee', 'accident','city']));
    }


    public function update(Request $request, $id)
    {
        $edit_accident = \App\EmployeeAccident::findOrFail($request->accident);

        $edit_accident->employees_id = $request->employees_id;
        $edit_accident->incident_date = $request->incident_date;
        $edit_accident->incident_time = $request->incident_time;
        $edit_accident->date_opened = $request->date_opened;
        $edit_accident->date_closed = $request->date_closed;
        $edit_accident->address = $request->address;
        $edit_accident->cities_id = $request->cities_id;
        $edit_accident->delivery_id = $request->delivery_id;
        $edit_accident->numberOfInjuries = $request->numberOfInjuries;
        $edit_accident->numberOfFatalities = $request->numberOfFatalities;
        $edit_accident->propertyDamage = $request->propertyDamage;
        $edit_accident->description = $request->description;

        $edit_accident->save();

        return $edit_accident;
    }

    
    public function destroy($id)
    {
        //
    }
}
