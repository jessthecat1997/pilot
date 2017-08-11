<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('locations.locations_index', compact(['provinces']));
    }

    public function store(Request $request)
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



    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
