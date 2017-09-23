<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ArrastreLclHeader;
use App\ArrastreLclDetail;
class ArrastreFeeLclController extends Controller
{
	public function index()
	{
		$basis_types = DB::table('basis_types')
		->select('id', 'abbreviation')
		->where('deleted_at', '=', null)
		->get();

		$lcl_types = DB::table('lcl_types')
		->select('id', 'name')
		->where('deleted_at', '=', null)
		->get();


		$locations = DB::table('locations')
		->select('id', 'locations.name')
		->where('deleted_at', '=', null)
		->get();
		return view('admin/maintenance.arrastre_lcl_index', compact(['basis_types','locations','lcl_types']));
	}


	public function store(Request $request)
	{
		$af_header = new ArrastreLclHeader;
		$af_header->dateEffective = $request->dateEffective;
		$af_header->locations_id = $request->locations_id;
		$af_header->save();

		$_lcl_types_id = json_decode(stripslashes($request->lcl_types_id), true);
		$_basis_types_id = json_decode(stripslashes($request->basis_types_id), true);
		$_amount = json_decode(stripslashes($request->amount), true);

		$tblRowLength = $request->tblLength;

		for($x = 0; $x < $tblRowLength; $x++)
		{
			$af_detail = new ArrastreLclDetail;
			$af_detail->arrastre_lcl_headers_id = $af_header->id;
			$af_detail->lcl_types_id = (string)$_lcl_types_id[$x];
			$af_detail->basis_types_id = (string)$_basis_types_id[$x];
			$af_detail->amount = (string)$_amount[$x];
			$af_detail->save();
		}


	} 
	public function update(Request $request, $id)
	{

		\DB::table('arrastre_lcl_details')
		->where('arrastre_lcl_headers_id','=', $request->af_head_id)
		->delete();

		$af_header= ArrastreLclHeader::findOrFail($id);
		$af_header->dateEffective = $request->dateEffective;
		$af_header->locations_id = $request->locations_id;
		$af_header->save();


		$_lcl_types_id = json_decode(stripslashes($request->lcl_types_id), true);
		$_basis_types_id = json_decode(stripslashes($request->basis_types_id), true);
		$_amount = json_decode(stripslashes($request->amount), true);

		$tblRowLength = $request->tblLength;

		for($x = 0; $x < $tblRowLength; $x++)
		{
			$af_detail = new ArrastreLclDetail;
			$af_detail->arrastre_lcl_headers_id = $af_header->id;
			$af_detail->lcl_types_id = (string)$_lcl_types_id[$x];
			$af_detail->basis_types_id = (string)$_basis_types_id[$x];
			$af_detail->amount = (string)$_amount[$x];
			$af_detail->save();
		}
	}

	public function destroy($id)
	{
		$new_af = ArrastreLclHeader::findOrFail($id);
		$new_af->delete();

	}

	public function af_lcl_maintain_data(Request $request){
		$rates = DB::table('arrastre_lcl_details')
		->join ('basis_types', 'basis_types.id','=','basis_types_id') 
		->join ('lcl_types', 'lcl_types.id','=','lcl_types_id')
		->select('basis_types.abbreviation AS basis_type', 'amount', 'basis_types_id', 'lcl_types.name as lcl_type', 'lcl_types_id')
		->where('arrastre_lcl_headers_id', '=', $request->af_id)
		->get();

		return $rates;
	}   
}
