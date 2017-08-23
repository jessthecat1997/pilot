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

    public function update(Request $request)
    {
        $vehicle = \DB::table('vehicles')
        ->where('plateNumber', $request->plateNumber)
        ->update([
            'model' => $request->model,
            'bodyType' => $request->bodyType
            ]);
        return $vehicle;
    }


    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

    }

    public function reactivate(Request $request)
    {
        $vehicle = Vehicle::withTrashed()
        ->where('id',$request->id)
        ->restore();

    }

    public function v_utilities(){

        return view('admin/utilities.vehicle_utility_index');
    }
}
