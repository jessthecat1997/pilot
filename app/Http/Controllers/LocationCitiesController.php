<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\LocationCities;
use App\LocationProvince;
use App\Http\Requests\StoreLocationCities;

class LocationCitiesController extends Controller
{
	public function index()
	{

		$provinces = DB::table('location_provinces')
		->select('name', 'id')
		->where('deleted_at', '=', null)
		->get();
		return view('admin/maintenance.location_city_index', compact(['provinces']));
	}

	public function store(StoreLocationCities $request)
	{
		

		for($i = 0; $i < count($request->name); $i++){
			$city = new LocationCities;
			$city->name = $request->name[$i];
			$city->provinces_id = $request->provinces_id[$i];
			$city->save();
			return $city;
		}
	}

	public function update(StoreLocationCities $request, $id)
	{
		$city = LocationCities::findOrFail($id);
        $city->name = $request->name;
        $city->provinces_id = $request->provinces_id;
        $city->save();

        return $city;
		
	}

	public function new_province(Request $request)
	{
		$lp = LocationProvince::create($request->all());
        return $lp;
	}


	public function destroy($id)
	{

		$city = LocationCities::findOrFail($id);
		$city->delete();
	}

	public function reactivate(Request $request)
    {
        $city = LocationCities::withTrashed()
        ->where('id',$request->id)
        ->restore();
        
    }

    public function lc_utilities(){

        return view('admin/utilities.location_city_utility_index');
    }


}
