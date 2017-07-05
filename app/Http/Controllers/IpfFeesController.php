<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IpfFee;
use App\Http\Requests\StoreIPFFee;


class IpfFeesController extends Controller
{
   
   
    public function index()
    {
       return view('admin/maintenance.ipf_fee_index');
    }

  
    public function store(StoreIPFFee $request)
    {
        $ipf = IpfFee::create($request->all());
        return $ipf;
    }


    public function update(StoreIPFFee $request, $id)
    {
        $ipf_fee = IpfFee::findOrFail($id);
        $ipf_fee->minimum = $request->minimum;
        $ipf_fee->maximum = $request->maximum;
        $ipf_fee->amount = $request->amount;
        $ipf_fee->save();

        return $ipf_fee;
    }

    
    public function destroy($id)
    {
        $ipf_fee = IpfFee::findOrFail($id);
        $ipf_fee->delete();
    }


     public function reactivate(Request $request)
    {
        $ipf_fee = IpfFee::withTrashed()
        ->where('id',$request->id)
        ->restore();
  
    }

    public function ipf_utilities(){

        return view('admin/utilities.ipf_fee_utility_index');
    }
}
