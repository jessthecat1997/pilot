<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LocationProvince;
use App\Http\Requests\StoreLocationProvince;
class LocationProvincesController extends Controller
{
public function index()
    {
          $provinces = \App\LocationProvince::all();
        return view('admin/maintenance.location_province_index', compact(['provinces']));
    }


    public function store(StoreLocationProvince $request)
    {

        $new_lp = new \App\LocationProvince;
        $new_lp->name = $request->provincename;
        $new_lp->save();

        return $new_lp; 
    }

    public function update(StoreLocationProvince $request, $id)
    {
        $province = LocationProvince::findOrFail($id);
        $province->name = $request->name;
        $province->save();

        return $province;
    }


    public function destroy($id)
    {
        $province = LocationProvince::findOrFail($id);
        $province->delete();

    }


    public function reactivate(Request $request)
    {
        $province = LocationProvince::withTrashed()
        ->where('id',$request->id)
        ->restore();
        
    }

    public function lp_utilities(){

        return view('admin/utilities.location_province_utility_index');
    }
}
