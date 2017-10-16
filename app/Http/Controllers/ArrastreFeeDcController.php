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
		$arrastres = DB::select("SELECT DISTINCT h.id, h.dateEffective, DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, locations.name AS location, GROUP_CONCAT(container_types.name) AS container_size, GROUP_CONCAT(dangerous_cargo_types.name) AS dc_type, GROUP_CONCAT(CONCAT('Php ' , FORMAT(d.amount, 2)) ORDER BY d.container_sizes_id ASC SEPARATOR '\n') AS amount FROM dangerous_cargo_types, container_types,locations,arrastre_dc_headers h JOIN arrastre_dc_details d ON h.id = d.arrastre_dc_headers_id WHERE container_types.id = container_sizes_id AND dangerous_cargo_types.id = dc_types_id AND locations_id = locations.id AND locations.deleted_at IS NULL AND container_types.deleted_at IS NULL AND h.deleted_at IS NULL AND d.deleted_at IS NULL AND dangerous_cargo_types.description IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");


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

		return view('admin/maintenance.arrastre_dc_index', compact(['sizes','locations', 'dc_types', 'arrastres']));
	}



	public function store(Request $request)
	{
		$af_header = new ArrastreDcHeader;
		$af_header->dateEffective = $request->dateEffective;
		$af_header->locations_id = $request->locations_id;
		$af_header->save();

		$_dc_types_id = json_decode(stripslashes($request->dc_types_id), true);
		$_container_sizes_id = json_decode($request->container_sizes_id);
		$_amount = json_decode(stripslashes($request->amount), true);

		$tblRowLength = $request->tblLength;


		for($x = 0; $x < count($_container_sizes_id); $x++)
		{
			for($y =0; $y < count($_dc_types_id[$x]); $y++ ){

				$af_detail = new ArrastreDcDetail;
				$af_detail->arrastre_dc_headers_id = $af_header->id;
				$af_detail->container_sizes_id = $_container_sizes_id[$x];
				$af_detail->dc_types_id = $_dc_types_id[$x][$y];
				$af_detail->amount = (string)$_amount[$x];
				$af_detail->save();
			}
			
		}
		return $af_header;
		


	} 
	public function update(Request $request, $id)
	{

		\DB::table('arrastre_dc_details')
		->where('arrastre_dc_headers_id','=', $request->af_head_id)
		->delete();

		$af_header= ArrastreDcHeader::findOrFail($id);
		$af_header->dateEffective = $request->dateEffective;
		$af_header->locations_id = $request->locations_id;
		$af_header->save();

		$_dc_types_id = json_decode(stripslashes($request->dc_types_id), true);
		$_container_sizes_id = json_decode($request->container_sizes_id);
		$_amount = json_decode(stripslashes($request->amount), true);

		$tblRowLength = $request->tblLength;


		for($x = 0; $x < count($_container_sizes_id); $x++)
		{
			for($y =0; $y < count($_dc_types_id[$x]); $y++ ){

				$af_detail = new ArrastreDcDetail;
				$af_detail->arrastre_dc_headers_id = $af_header->id;
				$af_detail->container_sizes_id = $_container_sizes_id[$x];
				$af_detail->dc_types_id = $_dc_types_id[$x][$y];
				$af_detail->amount = (string)$_amount[$x];
				$af_detail->save();
			}
			
		}
		return $af_header;
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
