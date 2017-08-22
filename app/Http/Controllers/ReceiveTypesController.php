<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReceiveType;
use App\Http\Requests\StoreReceiveType;

class ReceiveTypesController extends Controller
{
  public function index()
    {
        return view('admin/utilities.receive_type_index');
    }


    public function store(StoreReceiveType $request)
    {

        $rt = ReceiveType::create($request->all());
        return $rt;
    }

    public function update(StoreReceiveType $request, $id)
    {
        $receive_type = ReceiveType::findOrFail($id);
        $receive_type->name = $request->name;
        $receive_type->description = $request->description;
        $receive_type->save();

        return $receive_type;
    }


    public function destroy($id)
    {
        $receive_type = ReceiveType::findOrFail($id);
        $receive_type->delete();

    }


    public function reactivate(Request $request)
    {
        $receive_type = ReceiveType::withTrashed()
        ->where('id',$request->id)
        ->restore();
  
    }

    public function rt_utilities(){

        return view('admin/utilities.receive_type_utility_index');
    }
}
