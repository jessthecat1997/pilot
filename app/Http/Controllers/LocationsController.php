<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LocationRequest;
use DB;
use App\Location;

class LocationsController extends Controller
{

    public function index()
    {
        $provinces = DB::table('location_provinces')
        ->select('name', 'id')
        ->where('deleted_at', '=', null)
        ->get();

        $locations = DB::table('locations')
        ->join('location_cities AS B', 'locations.cities_id', '=', 'B.id')
        ->join('location_provinces AS C', 'B.provinces_id', '=', 'C.id')
        ->select('locations.id as location_id', 'locations.name AS location_name', 'locations.address AS location_address', 'B.name AS city_name', 'C.name AS province_name', 'B.id AS city_id', 'C.id AS province_id', 'locations.zipCode')
        ->where('locations.deleted_at', '=', null)
        ->orderBy('location_name')
        ->get();

        return view('locations.locations_index', compact(['provinces','locations']));
    }

    public function store(LocationRequest $request)
    {
        $location = Location::create($request->all());
        return $location;
    }

    public function get_location(Request $request){
       $location =  DB::table('locations')
        ->join('location_cities as A', 'cities_id', '=', 'A.id')
        ->join('location_provinces as B', 'A.provinces_id', '=', 'B.id')
        ->select('locations.address', 'A.name as city_name', 'B.name as province_name', 'zipCode')
        ->where('locations.id', '=', $request->id)
        ->get();
        return $location;
    }

    public function update(LocationRequest $request, $id)
    {
        $location = Location::findOrFail($id);
        $location->name = $request->name;
        $location->address = $request->address;
        $location->cities_id = $request->cities_id;
        $location->zipCode = $request->zipCode;

        $location->save();
        return $location;
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
    }

    public function reactivate(Request $request)
    {
        $location = Location::withTrashed()
        ->where('id',$request->id)
        ->restore();
        
    }

    public function location_utilities(){

        return view('admin/utilities.location_utility_index');
    }


}
