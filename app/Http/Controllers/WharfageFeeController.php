<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\WharfageHeader;
use App\WharfageDetail;
use App\Http\Requests\StoreWharfageFee;
class WharfageFeeController extends Controller
{
    public function index()
    {
        $sizes = \App\ContainerType::all();
        $locations = DB::table('locations')
        ->select('id', 'locations.name')
        ->where('deleted_at', '=', null)
        ->get();
        $wharfages = DB::select("SELECT DISTINCT h.id,locations.name AS location, h.dateEffective,DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, GROUP_CONCAT(container_types.name ORDER BY d.container_sizes_id ASC SEPARATOR '\n') AS container_size, GROUP_CONCAT(CONCAT('Php ' , FORMAT (d.amount, 2) ) ORDER BY d.container_sizes_id ASC SEPARATOR '\n' ) AS amount FROM container_types,locations,wharfage_headers h JOIN wharfage_details d ON h.id = d.wharfage_header_id WHERE container_types.id = container_sizes_id AND locations_id = locations.id AND locations.deleted_at IS NULL AND container_types.deleted_at IS NULL AND h.deleted_at IS NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

        return view('admin/maintenance.wharfage_index', compact(['sizes','locations', 'wharfages']));
    }

    
    public function store(StoreWharfageFee $request)
    {
       DB::beginTransaction();
       try{
        $wf_header = new WharfageHeader;
        $wf_header->dateEffective = $request->dateEffective;
        $wf_header->locations_id = $request->locations_id;
        $wf_header->save();


        $_container_sizes_id = json_decode(stripslashes($request->container_sizes_id), true);
        $_amount = json_decode(stripslashes($request->amount), true);

        $tblRowLength = $request->tblLength;

        for($x = 0; $x < $tblRowLength; $x++)
        {
            $wf_detail = new WharfageDetail;
            $wf_detail->wharfage_header_id = $wf_header->id;
            $wf_detail->container_sizes_id = (string)$_container_sizes_id[$x];
            $wf_detail->amount = (string)$_amount[$x];
            $wf_detail->save();
        }
        DB::commit();
        return $wf_header;

    }catch(\Exception  $e){
        DB::rollback();
    }


} 
public function update(StoreWharfageFee $request, $id)
{
   DB::beginTransaction();
   try{

    $wf = \DB::table('wharfage_details')
    ->where('wharfage_header_id','=', $request->wf_head_id)
    ->where('deleted_at', '=', NULL)
    ->get();

    for($i = 0; $i < count($wf); $i ++)
    {
        $del_wf =  WharfageDetail::findOrFail($wf[$i]->id);
        $del_wf->delete();
    }

    $wf_header= WharfageHeader::findOrFail($id);
    $wf_header->dateEffective = $request->dateEffective;
    $wf_header->locations_id = $request->locations_id;
    $wf_header->save();

    $_container_sizes_id = json_decode(stripslashes($request->container_sizes_id), true);
    $_amount = json_decode(stripslashes($request->amount), true);

    $tblRowLength = $request->tblLength;

    for($x = 0; $x < $tblRowLength; $x++)
    {
        $wf_detail = new WharfageDetail;
        $wf_detail->wharfage_header_id = $wf_header->id;
        $wf_detail->container_sizes_id = (string)$_container_sizes_id[$x];
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
    $new_wf = WharfageHeader::findOrFail($id);
    $new_wf->delete();

}

public function wf_maintain_data(Request $request){
    $rates = DB::table('wharfage_details')
    ->join ('container_types', 'container_types.id','=','container_sizes_id') 
    -> select('container_types.name AS container_size', 'amount', 'container_sizes_id', 'wharfage_details.deleted_at')
    ->where('wharfage_header_id', '=', $request->wf_id)
    ->where('wharfage_details.deleted_at', '=', null)
    ->get();

    return $rates;
}
}
