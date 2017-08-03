<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BrokerageFeeHeader;
use App\BrokerageFeeDetail;
use App\Http\Requests\StoreBrokerageFee;


class BrokerageFeesController extends Controller
{
    public function index()
    {
        return view('admin/maintenance/brokerage_fee_index');
    }

    public function store(StoreBrokerageFee $request)
    {

        $new_bf = new BrokerageFeeHeader;
        $new_bf->dateEffective = date_create($request->dateEffective);
        $new_bf->save();


        for($i = 0; $i < count($request->minimum); $i++){
            $bf_detail = new BrokerageFeeDetail;
            $bf_detail->minimum = $request->minimum[$i];
            $bf_detail->maximum = $request->maximum[$i];
            $bf_detail->amount = $request->amount[$i];
            
            $bf_detail->brokerage_fee_headers_id = $new_bf->id;
            $bf_detail->save();
        }

        return $new_bf->id;
    }

    public function update(StoreBrokerageFee $request, $id)
    {
        $new_bf = new BrokerageFeeHeader;
        $new_bf->dateEffective = date_create($request->dateEffective);
        $new_bf->save();


        for($i = 0; $i < count($request->minimum); $i++){
            $bf_detail = new BrokerageFeeDetail;
            $bf_detail->minimum = $request->minimum[$i];
            $bf_detail->maximum = $request->maximum[$i];
            $bf_detail->amount = $request->amount[$i];
            
            $bf_detail->bf_headers_id = $new_bf->id;
            $bf_detail->save();
        }

        return $new_bf->id;
    }


    public function destroy($id)
    {
        $new_bf = BrokerageFeeHeader::findOrFail($id);
        $new_bf->delete();
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
