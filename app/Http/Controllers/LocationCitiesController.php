<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\LocationProvince;
use App\LocationCities;
use App\Http\Requests\StoreLocationCities;

class LocationCitiesController extends Controller
{
	public function index()
	{

		$provinces = DB::table('location_provinces')
		->select('name', 'id')
		->where('deleted_at', '=', null)
		->get();

		return view('admin/maintenance.location_city_index',  compact(['provinces']));
	}

	public function store(StoreLocationCities $request)
	{
		$province = new LocationProvince;
		

		for($i = 0; $i < count($request->minimum); $i++){
			$city = new LocationCities;
			$city->name = $request->name[$i];
			$city->provinces_id = $province->id;
			$city->save();
		}

		return $province->id;
	}

	public function update(StoreLocationCities $request, $id)
	{
		$province= LocationProvince::findOrFail($id);
		$province->dateEffective = $request->dateEffective;

		for($i = 0; $i < count($request->minimum); $i++){
			$city = LocationCities::findOrFail($id);
			$city->name = $request->name[$i];
			$city->provinces_id = $province->id;
			$city->save();
		}
		return $province;
		return $city;
	}


	public function destroy($id)
	{

		$province = LocationProvince::findOrFail($id);
		$province->delete();
	}


}
