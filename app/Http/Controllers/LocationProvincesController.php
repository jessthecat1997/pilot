<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LocationProvince;
use App\Http\Requests\StoreLocationProvince;
class LocationProvincesController extends Controller
{
public function index()
    {
        return view('admin/maintenance.location_province_index');
    }


    public function store(StoreLocationProvince $request)
    {

        $lp = LocationProvince::create($request->all());
        return $lp;
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
}
