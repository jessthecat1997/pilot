<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CdsFee;
use App\Http\Requests\StoreCDSFee;

class CdsFeesController extends Controller
{

  public function index()
  {

   $cdss = \DB::select("SELECT * , DATEDIFF(dateEffective, CURRENT_DATE()) AS diff FROM cds_fees where deleted_at is null ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");
    

    $cds_fee = \App\CdsFee::all();

    if(count($cdss) == 0)
    {
      $no_current = "true";
    }
    else
    {
      $no_current = "false";
      $current = $cdss[count($cdss) -1 ];
      \DB::update('UPDATE cds_fees SET currentFee = 0 WHERE id != ' . $current->id);
      \DB::update('UPDATE cds_fees SET currentFee = 1 WHERE id = ' . $current->id);

      $cds_fee_current = \DB::table('cds_fees')
      ->select('fee')
      ->where('currentFee', '=', 1)
      ->get();

      if(count($cds_fee_current) == 0){
        $cds_fee_current[0]->fee = 0;
      }

    }
    return view('admin/maintenance.cds_fee_index', compact(['cds_fee_current','cds_fee', 'no_current']));
  }


  public function store(StoreCDSFee $request)
  {
    $cds = CdsFee::create($request->all());
    return $cds;

  }


  public function update(StoreCDSFee $request, $id)
  {
    $cds_fee = CdsFee::findOrFail($id);
    $cds_fee->fee = $request->fee;
    $cds_fee->currentFee = $request->currentFee;
    $cds_fee->dateEffective = $request->dateEffective;
    $cds_fee->save();

    return $cds_fee;
  }


  public function destroy($id)
  {
    $cds_fee = CdsFee::findOrFail($id);
    $cds_fee->delete();
  }

  public function reactivate(Request $request)
  {
    $cds_fee = CdsFee::withTrashed()
    ->where('id',$request->id)
    ->restore();

  }

  public function cds_utilities(){

    return view('admin/utilities.cds_fee_utility_index');
  }




}
