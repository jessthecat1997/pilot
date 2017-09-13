<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\WharfageLclHeader;
use App\WharfageLclDetail;

class WharfageFeeLclController extends Controller
{
     public function index()
    {
    	 $basis_types = \App\BasisType::all();
      
       
        $locations = DB::table('locations')
        ->select('id', 'locations.name')
        ->where('deleted_at', '=', null)
        ->get();
        return view('admin/maintenance.wharfage_lcl_index', compact(['basis_types','locations']));
    }

    
    public function store(Request $request)
    {
        $wf_header = new WharfageLclHeader;
        $wf_header->locations_id = $request->locations_id;
        $wf_header->save();


        $_basis_types_id = json_decode(stripslashes($request->basis_types_id), true);
        $_amount = json_decode(stripslashes($request->amount), true);

        $tblRowLength = $request->tblLength;

        for($x = 0; $x < $tblRowLength; $x++)
        {
            $wf_detail = new WharfageLclDetail;
            $wf_detail->wharfage_header_id = $wf_header->id;
            $wf_detail->basis_types_id = (string)$_basis_types_id[$x];
            $wf_detail->amount = (string)$_amount[$x];
            $wf_detail->save();
        }


    } 
    public function update(Request $request, $id)
    {

        
        $wf_header= WharfageLclHeader::findOrFail($id);
        $wf_header->locations_id = $request->locations_id;
        $wf_header->save();

    
        $_basis_types_id = json_decode(stripslashes($request->basis_types_id), true);
        $_amount = json_decode(stripslashes($request->amount), true);

        $tblRowLength = $request->tblLength;

        for($x = 0; $x < $tblRowLength; $x++)
        {
            $wf_detail = new WharfageLclDetail;
            $wf_detail->wharfage_header_id =$wf_header->id;
            $wf_detail->basis_types_id = (string)$_basis_types_id[$x];
            $wf_detail->amount = (string)$_amount[$x];
            $wf_detail->save();
        }
    }

    public function destroy($id)
    {
        $new_wf = WharfageLclHeader::findOrFail($id);
        $new_wf->delete();

    }

    public function wf_maintain_data(Request $request){
        $rates = DB::table('wharfage_details')
        ->join ('container_types', 'container_types.id','=','basis_types_id') 
        -> select('container_types.name AS basis_types', 'amount', 'basis_types_id')
        ->where('wharfage_header_id', '=', $request->wf_id)
        ->get();

        return $rates;
    }
}