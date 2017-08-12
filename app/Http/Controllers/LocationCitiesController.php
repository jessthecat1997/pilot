<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
		return view('admin/maintenance.location_city_index', compact(['provinces']));
	}

	public function store(StoreLocationCities $request)
	{

		for($i = 0; $i < count($request->name); $i++){
			$city = new LocationCities;
			$city->name = $request->name[$i];
			$city->provinces_id = $request->provinces_id;
			$city->save();
			return $city->id;
		}

		


	}

	public function update(StoreLocationCities $request, $id)
	{
		
	}


	public function destroy($id)
	{

		$province = LocationProvince::findOrFail($id);
		$province->delete();
	}


}
