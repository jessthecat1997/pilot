<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ArrastreHeader;
use App\ArrastreDetail;

class ArrastreFeesController extends Controller
{

    public function index()
    {
        $sizes = \App\ContainerType::all();
        $locations = DB::table('locations')
        ->select('id', 'locations.name')
        ->where('deleted_at', '=', null)
        ->get();
        return view('admin/maintenance.arrastre_index', compact(['sizes','locations']));
    }

    
    public function store(Request $request)
    {
        $af_header = new ArrastreHeader;
        $af_header->locations_id = $request->locations_id;
        $af_header->save();


        $_container_sizes_id = json_decode(stripslashes($request->container_sizes_id), true);
        $_amount = json_decode(stripslashes($request->amount), true);

        $tblRowLength = $request->tblLength;

        for($x = 0; $x < $tblRowLength; $x++)
        {
            $af_detail = new ArrastreDetail;
            $af_detail->arrastre_header_id = $af_header->id;
            $af_detail->container_sizes_id = (string)$_container_sizes_id[$x];
            $af_detail->amount = (string)$_amount[$x];
            $af_detail->save();
        }


    } 
    public function update(Request $request, $id)
    {

        
        $af_header= ArrastreHeader::findOrFail($id);
        $af_header->locations_id = $request->locations_id;
        $af_header->save();

    
        $_container_size_id = json_decode(stripslashes($request->container_size_id), true);
        $_amount = json_decode(stripslashes($request->amount), true);

        $tblRowLength = $request->tblLength;

        for($x = 0; $x < $tblRowLength; $x++)
        {
            $af_detail = new ArrastreDetail;
            $af_detail->arrastre_header_id =$af_header->id;
            $af_detail->container_sizes_id = (string)$_container_size_id[$x];
            $af_detail->amount = (string)$_amount[$x];
            $af_detail->save();
        }
    }

    public function destroy($id)
    {
        $new_af = ArrastreHeader::findOrFail($id);
        $new_af->delete();

    }

    public function af_maintain_data(Request $request){
        $rates = DB::table('arrastre_details')
        ->join ('container_types', 'container_types.id','=','container_sizes_id') 
        -> select('container_types.name AS container_size', 'amount', 'container_sizes_id')
        ->where('arrastre_header_id', '=', $request->af_id)
        ->get();

        return $rates;
    }
}
