<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreLclType;
use App\LclType;

class LclTypesController extends Controller
{
    public function index()
    {
        return view('admin/maintenance.lcl_type_index');
    }


    public function store(StoreLclType $request)
    {
        $lcl = LclType::create($request->all());
        return $lcl;
    }

    public function update(StoreLclType $request, $id)
    {
        $lcl = LclType::findOrFail($id);
        $lcl->name = $request->name;
        $lcl->description = $request->description;
        $lcl->save();

        return $lcl;
    }


    public function destroy($id)
    {
        $lcl = LclType::findOrFail($id);
        $lcl->delete();
    }

    public function reactivate(Request $request)
    {
        $lcl = LclType::withTrashed()
        ->where('id',$request->id)
        ->restore();
  
    }

    public function lcl_utilities(){

       // return view('admin/utilities.lcl_types_utility_index');
    }
}
