<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\VehicleType;
use App\Http\Requests\StoreVehicle;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function index()
    {
        $vts = VehicleType::with('vehicle')->get();

        return view('admin/maintenance/vehicle_index', compact(["vts"]));
    }


    public function store(StoreVehicle $request)
    {
        $v = Vehicle::create($request->all());
        return $v;
    }

    public function update(StoreVehicle $request)
    {

    }

    public function v_update(StoreVehicle $request)
    {
        $plate = str_replace('%', ' ', $request->plateNumber);
        $v = Vehicle::where('plateNumber', $plate)->firstOrFail();
        $v->model = $request->model;
        $v->dateRegistered = $request->dateRegistered;
        $v->bodyType = $request->bodyType;

        $v->save();
        
        return $v;
    }


    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

    }

    public function reactivate(Request $request)
    {

        $plate = str_replace('%', ' ', $request->id);

        $vehicle = \DB::table('vehicles')
        ->where('plateNumber', '=', $plate)
        ->update([
            'deleted_at' => null,
        ]);


    }

    public function v_utilities(){

        return view('admin/utilities.vehicle_utility_index');
    }
}
