<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBrokerageStatusType;
use App\Brokerage_status_type;

class BrokerageStatusTypesController extends Controller
{
 
    public function index()
    {
        return view('admin/maintenance/brokerage_status_type_index');
    }


    public function store(StoreBrokerageStatusType $request)
    {

        $bst = Brokerage_status_type::create($request->all());
        return $bst;
    }

    public function update(StoreBrokerageStatusType $request, $id)
    {
        $brokerage_status = Brokerage_status_type::findOrFail($id);
        $brokerage_status->description = $request->description;
        $brokerage_status->save();

        return $brokerage_status;
    }


    public function destroy($id)
    {
        $brokerage_status = Brokerage_status_type::findOrFail($id);
        $brokerage_status->delete();
    }

    public function reactivate(Request $request)
    {
        $brokerage_status = Brokerage_status_type::withTrashed()
        ->where('id',$request->id)
        ->restore();
  
    }

    public function bst_utilities(){

        return view('admin/utilities.brokerage_status_type_utility_index');
    }
}
