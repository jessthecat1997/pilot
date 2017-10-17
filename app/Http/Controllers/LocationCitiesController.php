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
		$cities =   DB::select("SELECT p.name as 'province' , c.name as 'city', c.id as'id'  FROM location_provinces p INNER JOIN location_cities c ON p.id = c.provinces_id where c.deleted_at is null  and p.deleted_at is null order by p.name");
		$provinces =  \App\LocationProvince::all();
		return view('admin/maintenance.location_city_index', compact(['provinces', 'cities']));
	}

	public function store(StoreLocationCities $request)
	{
		$new_city  = new \App\LocationCities;
		$new_city->name = $request->name;
		$new_city->provinces_id = $request->provinces_id;

		$new_city->save();

		return $new_city;
	}

	public function update(StoreLocationCities $request, $id)
	{
		$city = LocationCities::findOrFail($id);
        $city->name = $request->name;
        $city->provinces_id = $request->provinces_id;
        $city->save();

        return $city;
		
	}

	public function new_province(StoreLocationCities $request)
	{
		$new_lp = new \App\LocationProvince;
		$new_lp->name = $request->provincename;
		$new_lp->save();

		return $new_lp; 

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
