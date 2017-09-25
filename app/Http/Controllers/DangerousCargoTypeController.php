<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDangerousCargoType;
use App\DangerousCargoType;

class DangerousCargoTypeController extends Controller
{

    public function index()
    {
         $dcts = \App\DangerousCargoType::all();
        return view('admin/maintenance.dangerous_cargo_type_index',compact(['dcts']));
    }


    public function store(StoreDangerousCargoType $request)
    {
        $dct = DangerousCargoType::create($request->all());
        return $dct;
    }

    public function update(StoreDangerousCargoType $request, $id)
    {
        $dct = DangerousCargoType::findOrFail($id);
        $dct->name = $request->name;
        $dct->description = $request->description;
        $dct->save();

        return $dct;
    }


    public function destroy($id)
    {
        $dct = DangerousCargoType::findOrFail($id);
        $dct->delete();
    }

    public function reactivate(Request $request)
    {
        $dct = DangerousCargoType::withTrashed()
        ->where('id',$request->id)
        ->restore();
  
    }

    public function dct_utilities(){

        return view('admin/utilities.DangerousCargoType_utility_index');
    }
}
