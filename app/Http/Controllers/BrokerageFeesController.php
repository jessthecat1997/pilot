<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BrokerageFee;
use App\Http\Requests\StoreBrokerageFee;

class BrokerageFeesController extends Controller
{
    public function index()
    {
        return view('admin/maintenance/brokerage_fee_index');
    }


    public function store(StoreBrokerageFee $request)
    {

        $bf = BrokerageFee::create($request->all());
        return $bf;
    }

    public function update(StoreBrokerageFee $request, $id)
    {
        $brokerage_fee = BrokerageFee::findOrFail($id);
        $brokerage_fee->minimum = $request->minimum;
        $brokerage_fee->maximum = $request->maximum;
        $brokerage_fee->fee = $request->amount;
        
        $brokerage_fee->save();

        return $brokerage_fee;
    }


    public function destroy($id)
    {
        $brokerage_fee = BrokerageFee::findOrFail($id);
        $brokerage_fee->delete();
    }

    public function reactivate(Request $request)
    {
        $brokerage_fee = BrokerageFee::withTrashed()
        ->where('id',$request->id)
        ->restore();
  
    }

    public function bf_utilities(){

        return view('admin/utilities.brokerage_fee_utility_index');
    }
}
