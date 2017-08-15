<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VehicleType;
use App\Http\Requests\StoreVehicleType;


class VehicleTypesController extends Controller
{

    public function index()
    {
        return view('admin/maintenance/vehicle_type_index');
    }


    public function store(StoreVehicleType $request)
    {

        $vt = VehicleType::create($request->all());
        return $vt;
    }

    public function update(StoreVehicleType $request, $id)
    {
        
        $vehicle_type = VehicleType::findOrFail($id);
        $vehicle_type->name = $request->name;
        $vehicle_type->description = $request->description;
        $vehicle_type->withContainer = $request->withContainer;
        $vehicle_type->save();

        return $vehicle_type;
    }


    public function destroy($id)
    {
        $vehicle_type = VehicleType::findOrFail($id);
        $vehicle_type->delete();

    }

    public function reactivate(Request $request)
    {
        $vehicle_type = VehicleType::withTrashed()
        ->where('id',$request->id)
        ->restore();
        
    }

    public function vt_utilities(){

        return view('admin/utilities.vehicle_type_utility_index');
    }
}
