<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BrokerageFeeHeader;
use App\BrokerageFeeDetail;
use App\Http\Requests\StoreBrokerageFee;
use Illuminate\Support\Facades\DB;

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

        $_minimum = json_decode(stripslashes($request->minimum), true);
        $_maximum = json_decode(stripslashes($request->maximum), true);
        $_amount = json_decode(stripslashes($request->amount), true);


        for($i = 0; $i < count($_minimum); $i++){
            $bf_detail = new BrokerageFeeDetail;
            $bf_detail->minimum = (string)$_minimum[$i];
            $bf_detail->maximum = (string)$_maximum[$i];
            $bf_detail->amount = (string)$_amount[$i];
            
            $bf_detail->brokerage_fee_headers_id = $new_bf->id;
            $bf_detail->save();
        }

    }

    public function update(StoreBrokerageFee $request, $id)
    {
        \DB::table('brokerage_fee_details')
        ->where('brokerage_fee_headers_id','=', $request->bf_head_id)
        ->delete();

        $new_bf= BrokerageFeeHeader::findOrFail($id);
        $new_bf->dateEffective = $request->dateEffective;
        $new_bf->save();

        $_minimum = json_decode(stripslashes($request->minimum), true);
        $_maximum = json_decode(stripslashes($request->maximum), true);
        $_amount = json_decode(stripslashes($request->amount), true);


        for($x = 0; $x < count($_minimum); $x++)
        {
            $bf_detail = new BrokerageFeeDetail;
            $bf_detail->brokerage_fee_headers_id = $new_bf->id;
            $bf_detail->minimum = (string)$_minimum[$x];
            $bf_detail->maximum = (string)$_maximum[$x];
            $bf_detail->amount = (string)$_amount[$x];
            $bf_detail->save();
        }
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

    public function bf_maintain_data(Request $request){
        $rates = DB::table('brokerage_fee_details')
        ->where('brokerage_fee_headers_id', '=', $request->bf_id)
        ->get();

        return $rates;
    }
}
