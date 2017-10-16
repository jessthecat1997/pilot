<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\WharfageLclHeader;
use App\WharfageLclDetail;
use App\Http\Requests\StoreWharfageFeeLCL;
class WharfageFeeLclController extends Controller
{
 public function index()
 {
  $basis_types = DB::table('basis_types')
  ->select('id', 'abbreviation')
  ->where('deleted_at', '=', null)
  ->get();


  $locations = DB::table('locations')
  ->select('id', 'locations.name')
  ->where('deleted_at', '=', null)
  ->get();

  $wharfages = DB::select("SELECT DISTINCT h.id,h.dateEffective,locations.name AS location, DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, GROUP_CONCAT(basis_types.abbreviation SEPARATOR '\n') AS basis_type, GROUP_CONCAT(CONCAT('Php ' , FORMAT(d.amount ,2)) SEPARATOR '\n') AS amount FROM basis_types,locations, wharfage_lcl_headers h JOIN wharfage_lcl_details d ON h.id = d.wharfage_lcl_headers_id WHERE locations_id = locations.id AND basis_types.id = d.basis_types_id AND basis_types.deleted_at IS NULL AND locations.deleted_at IS NULL AND h.deleted_at IS NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

  return view('admin/maintenance.wharfage_lcl_index', compact(['basis_types','locations','wharfages']));
}


public function store(StoreWharfageFeeLCL $request)
{
 DB::beginTransaction();
 try{
  $wf_header = new WharfageLclHeader;
  $wf_header->dateEffective = $request->dateEffective;
  $wf_header->locations_id = $request->locations_id;
  $wf_header->save();


  $_basis_types_id = json_decode(stripslashes($request->basis_types_id), true);
  $_amount = json_decode(stripslashes($request->amount), true);

  $tblRowLength = $request->tblLength;

  for($x = 0; $x < $tblRowLength; $x++)
  {
    $wf_detail = new WharfageLclDetail;
    $wf_detail->wharfage_lcl_headers_id = $wf_header->id;
    $wf_detail->basis_types_id = (string)$_basis_types_id[$x];
    $wf_detail->amount = (string)$_amount[$x];
    $wf_detail->save();
  }
  DB::commit();
  return $wf_header;

}catch(\Exception  $e){
  DB::rollback();
}


} 
public function update(StoreWharfageFeeLCL $request, $id)
{
 DB::beginTransaction();
 try{

  \DB::table('wharfage_lcl_details')
  ->where('wharfage_lcl_headers_id','=', $request->wf_head_id)
  ->delete();

  $wf_header= WharfageLclHeader::findOrFail($id);
  $wf_header->dateEffective = $request->dateEffective;
  $wf_header->locations_id = $request->locations_id;
  $wf_header->save();


  $_basis_types_id = json_decode(stripslashes($request->basis_types_id), true);
  $_amount = json_decode(stripslashes($request->amount), true);

  $tblRowLength = $request->tblLength;

  for($x = 0; $x < $tblRowLength; $x++)
  {
    $wf_detail = new WharfageLclDetail;
    $wf_detail->wharfage_lcl_headers_id = $wf_header->id;
    $wf_detail->basis_types_id = (string)$_basis_types_id[$x];
    $wf_detail->amount = (string)$_amount[$x];
    $wf_detail->save();
  }
  DB::commit();
  return $wf_header;

}catch(\Exception  $e){
  DB::rollback();
}
}

public function destroy($id)
{
  $new_wf = WharfageLclHeader::findOrFail($id);
  $new_wf->delete();

}

public function wf_lcl_maintain_data(Request $request){
  $rates = DB::table('wharfage_lcl_details')
  ->join ('basis_types', 'basis_types.id','=','basis_types_id') 
  ->select('basis_types.abbreviation AS basis_type', 'amount', 'basis_types_id', 'wharfage_lcl_details.deleted_at')
  ->where('wharfage_lcl_headers_id', '=', $request->wf_id)
  ->where('wharfage_lcl_details.deleted_at', '=', null)
  ->get();

  return $rates;
}
}
