<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ImportProcessingFeeHeader;
use App\ImportProcessingFeeDetail;
use App\Http\Requests\StoreIPFFee;
class ImportProcessingFeesController extends Controller
{
	public function index()
	{
		return view('admin/maintenance.ipf_fee_index');
	}

	public function store(Request $request)
	{
		$ipf_header = new ImportProcessingFeeHeader;
		$ipf_header->dateEffective = $request->dateEffective;
		$ipf_header->save();

		$_minimum = json_decode(stripslashes($request->minimum), true);
		$_maximum = json_decode(stripslashes($request->maximum), true);
		$_amount = json_decode(stripslashes($request->amount), true);

		$tblRowLength = $request->tblLength;

		for($x = 0; $x < $tblRowLength; $x++)
		{
			$ipf_detail = new ImportProcessingFeeDetail;
			$ipf_detail->ipf_headers_id = $ipf_header->id;
			$ipf_detail->minimum = (string)$_minimum[$x];
			$ipf_detail->maximum = (string)$_maximum[$x];
			$ipf_detail->amount = (string)$_amount[$x];
			$ipf_detail->save();
		}


	}

	public function update(StoreIPFFee $request, $id)
	{
		$new_ipf= ImportProcessingFeeHeader::findOrFail($id);
		$new_ipf->dateEffective = $request->dateEffective;

		for($i = 0; $i < count($request->minimum); $i++){
			$ipf_detail = ImportProcessingFeeDetail::findOrFail($id);
			$ipf_detail->minimum = $request->minimum[$i];
			$ipf_detail->maximum = $request->maximum[$i];
			$ipf_detail->amount = $request->amount[$i];
			$ipf_detail->save();
		}
		return $new_ipf;
		return $ipf_detail;
	}


	public function destroy($id)
	{

		$new_ipf = ImportProcessingFeeHeader::findOrFail($id);
		$new_ipf->delete();
	}

	public function ipf_maintain_data(Request $request){
		$rates = DB::table('import_processing_fee_details')
		->where('ipf_headers_id', '=', $request->ipf_id)
		->get();

		return $rates;
	}


}
