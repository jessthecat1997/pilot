<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\WharfageHeader;
use App\WharfageDetail;
class WharfageFeeController extends Controller
{
    public function index()
    {
        $sizes = \App\ContainerType::all();
        $locations = DB::table('locations')
        ->select('id', 'locations.name')
        ->where('deleted_at', '=', null)
        ->get();
        return view('admin/maintenance.wharfage_index', compact(['sizes','locations']));
    }

    
    public function store(Request $request)
    {
        $wf_header = new WharfageHeader;
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


    } 
    public function update(Request $request, $id)
    {

        $wf_header= WharfageHeader::findOrFail($id);
        $wf_header->locations_id = $request->locations_id;
        $wf_header->save();

        $_container_size_id = json_decode(stripslashes($request->container_size_id), true);
        $_amount = json_decode(stripslashes($request->amount), true);

        $tblRowLength = $request->tblLength;

        for($x = 0; $x <  $tblRowLength; $x++)
        {
            $wf_detail = WharfageDetail::findOrFail($_container_size_id[$x]);
            $wf_detail->amount = (string)$_amount[$x];
            $wf_detail->save();
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
        -> select('container_types.name AS container_size', 'amount', 'container_sizes_id')
        ->where('wharfage_header_id', '=', $request->wf_id)
        ->get();

        return $rates;
    }
}
