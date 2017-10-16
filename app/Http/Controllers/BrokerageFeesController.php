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
      $bfs = DB::select("SELECT h.id, h.dateEffective, h.deleted_at , DATEDIFF(dateEffective, CURRENT_DATE()) AS diff ,
        GROUP_CONCAT(CONCAT('$ ' , FORMAT (d.minimum,2)) ORDER BY d.minimum ASC  SEPARATOR '\n') AS minimum, GROUP_CONCAT(CONCAT('$ ' , FORMAT (d.maximum,2)) ORDER BY d.minimum ASC SEPARATOR '\n') AS maximum, GROUP_CONCAT(CONCAT('Php ' , FORMAT (d.amount,2)) ORDER BY d.minimum ASC SEPARATOR '\n') AS amount FROM brokerage_fee_headers h INNER JOIN brokerage_fee_details d ON h.id = d.brokerage_fee_headers_id where h.deleted_at is null AND d.deleted_at is null GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");
      

      return view('admin/maintenance/brokerage_fee_index', compact(['bfs']));
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
    return $new_bf;

}

public function update(StoreBrokerageFee $request, $id)
{
    $bf = \DB::table('brokerage_fee_details')
    ->where('brokerage_fee_headers_id','=', $request->bf_head_id)
    ->where('deleted_at', '=', NULL)
    ->get();


    for($i = 0; $i < count($bf); $i ++)
    {
        $del_bf = BrokerageFeeDetail::findOrFail($bf[$i]->id);
        $del_bf->delete();
    }

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
    return $new_bf;
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
    ->where('deleted_at', '=', NULL)
    ->get();

    return $rates;
}
}
