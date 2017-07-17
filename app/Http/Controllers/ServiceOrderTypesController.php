<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceOrderType;
use App\service_order_type;

class ServiceOrderTypesController extends Controller
{

    public function index()
    {
        return view('admin/maintenance.service_order_type_index');
    }


    public function store(StoreServiceOrderType $request)
    {
        $sot = service_order_type::create($request->all());
        return $sot;
    }

    public function update(StoreServiceOrderType $request, $id)
    {
        $sot = service_order_type::findOrFail($id);
        $sot->name = $request->name;
        $sot->description = $request->description;
        $sot->save();

        return $sot;
    }


    public function destroy($id)
    {
        $sot = service_order_type::findOrFail($id);
        $sot->delete();
    }

    public function reactivate(Request $request)
    {
        $sot = service_order_type::withTrashed()
        ->where('id',$request->id)
        ->restore();
  
    }

    public function sot_utilities(){

        return view('admin/utilities.service_order_type_utility_index');
    }
}
