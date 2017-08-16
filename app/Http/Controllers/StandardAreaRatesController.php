<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\StandardAreaRateHeader;
use App\StandardAreaRateDetail;


class StandardAreaRatesController extends Controller
{
	public function index()
	{

		$locations = \App\Location::all();

        $provinces = \App\LocationProvince::all();
		return view('admin/maintenance.standard_area_rates_index', compact(['provinces','locations']));
	}

	public function store(Request $request)
	{
		$new_sar = new StandardAreaRateHeader;
		$new_sar->dateEffective = date_create($request->dateEffective);
		$new_sar->save();


		for($i = 0; $i < count($request->location); $i++){
			$sar_detail = new StandardAreaRateDetail;
			$sar_detail->areaFrom = $request->areaFrom[$i];
			$sar_detail->areaTo = $request->areaTo[$i];
			$sar_detail->amount = $request->amount[$i];
			$sar_detail->standard_area_rate_headers_id = $new_sar->id;
			$sar_detail->save();
		}

		return $new_sar->id;
	}

	


	public function destroy($id)
	{

		$new_ipf = ImportProcessingFeeHeader::findOrFail($id);
		$new_ipf->delete();
	}
}
