<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ArrastreLclHeader;
use App\ArrastreLclDetail;
use App\Http\Requests\StoreArrastreFeeLCL;
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

		$arrastres = DB::select("SELECT DISTINCT DATEDIFF(h.dateEffective, CURRENT_DATE()) AS diff , h.id,locations.name AS location, h.dateEffective, GROUP_CONCAT(lcl_types.name SEPARATOR '\n') AS lcl_type, GROUP_CONCAT(basis_types.abbreviation SEPARATOR '\n') AS basis_type, GROUP_CONCAT(CONCAT('Php ' , FORMAT( d.amount, 2)) SEPARATOR '\n' ) AS amount FROM lcl_types, basis_types,locations, arrastre_lcl_headers h JOIN arrastre_lcl_details d ON h.id = d.arrastre_lcl_headers_id WHERE locations_id = locations.id AND lcl_types.id = d.lcl_types_id AND basis_types.id = d.basis_types_id AND basis_types.deleted_at IS NULL AND locations.deleted_at IS NULL AND h.deleted_at IS NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

		return view('admin/maintenance.arrastre_lcl_index', compact(['basis_types','locations','lcl_types', 'arrastres']));
	}


	public function store(StoreArrastreFeeLCL $request)
	{
		DB::beginTransaction();
		try{
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
			DB::commit();
			return $af_header;
		}catch(\Exception  $e){
			DB::rollback();
		}


	} 
	public function update(StoreArrastreFeeLCL $request, $id)
	{
		DB::beginTransaction();
		try{
			$af = \DB::table('arrastre_lcl_details')
			->where('arrastre_lcl_headers_id','=', $request->af_head_id)
			->where('deleted_at', '=', NULL)
			->get();

			for($i = 0; $i < count($af); $i ++)
			{
				$del_af =  ArrastreLCLDetail::findOrFail($af[$i]->id);
				$del_af->delete();
			}

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
			DB::commit();
			return $af_header;
		}catch(\Exception  $e){
			DB::rollback();
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
