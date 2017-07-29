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

	public function store(StoreIPFFee $request)
	{
		$new_ipf = new ImportProcessingFeeHeader;
		$new_ipf->dateEffective = date_create($request->dateEffective);
		$new_ipf->save();


		for($i = 0; $i < count($request->minimum); $i++){
			$ipf_detail = new ImportProcessingFeeDetail;
			$ipf_detail->minimum = $request->minimum[$i];
			$ipf_detail->maximum = $request->maximum[$i];
			$ipf_detail->amount = $request->amount[$i];
			
			$ipf_detail->ipf_headers_id = $new_ipf->id;
			$ipf_detail->save();
		}

		return $new_ipf->id;
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



}
