<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ArrastreDcHeader;
use App\ArrastreDcDetail;

class ArrastreFeeDcController extends Controller
{
	public function index()
	{
		$sizes = DB::table('container_types')
        ->select('id','container_types.name')
        ->where('deleted_at', '=', null)
        ->get();

		$dc_types = DB::table('dangerous_cargo_types')
		->select('id', 'name')
		->where('deleted_at', '=', null)
		->get();


		$locations = DB::table('locations')
		->select('id', 'locations.name')
		->where('deleted_at', '=', null)
		->get();

		return view('admin/maintenance.arrastre_dc_index', compact(['sizes','locations', 'dc_types']));
	}



	public function store(Request $request)
	{
		$af_header = new ArrastreDcHeader;
		$af_header->locations_id = $request->locations_id;
		$af_header->save();

		$_dc_types_id = json_decode(stripslashes($request->dc_types_id), true);
		$_container_sizes_id = json_decode(stripslashes($request->container_sizes_id), true);
		$_amount = json_decode(stripslashes($request->amount), true);

		$tblRowLength = $request->tblLength;
		
		for($x = 0; $x < $tblRowLength; $x++)
		{
			$af_detail = new ArrastreDcDetail;
			$af_detail->arrastre_header_id = $af_header->id;
			$af_detail->container_sizes_id = (string)$_container_sizes_id[$x];
			$af_detail->dc_types_id = (string)$_dc_types_id[$x];
			$af_detail->amount = (string)$_amount[$x];
			$af_detail->save();
		}


	} 
	public function update(Request $request, $id)
	{

		\DB::table('arrastre_lcl_details')
		->where('arrastre_lcl_headers_id','=', $request->af_head_id)
		->delete();

		$af_header= ArrastreDcHeader::findOrFail($id);
		$af_header->locations_id = $request->locations_id;
		$af_header->save();


		$_dc_types_id = json_decode(stripslashes($request->dangerous_cargo_types), true);
		$_container_sizes_id = json_decode(stripslashes($request->container_sizes_id), true);
		$_amount = json_decode(stripslashes($request->amount), true);

		$tblRowLength = $request->tblLength;

		for($x = 0; $x < $tblRowLength; $x++)
		{
			$af_detail = new ArrastreDcDetail;
			$af_detail->arrastre_header_id = $af_header->id;
			$af_detail->container_sizes_id = (string)$_container_sizes_id[$x];
			$af_detail->dc_types_id = (string)$_dc_types_id[$x];
			$af_detail->amount = (string)$_amount[$x];
			$af_detail->save();
		}
	}

	public function destroy($id)
	{
		$new_af = ArrastreDcHeader::findOrFail($id);
		$new_af->delete();

	}

	public function af_dc_maintain_data(Request $request){
		
		$rates = DB::table('arrastre_dc_details')
		->join ('container_types', 'container_types.id','=','container_sizes_id') 
		->join ('dangerous_cargo_types', 'dangerous_cargo_types.id','=','dc_types_id')
		-> select('container_types.name AS container_size', 'amount', 'container_sizes_id')
		->where('arrastre_header_id', '=', $request->af_id)
		->get();

		return $rates;
	} 
}
