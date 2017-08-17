<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\StandardAreaRate;
use App\Http\Requests\StoreStandardAreaRate;

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
		 $sar = StandardAreaRate::create($request->all());
        return $sar;
	}

	public function update(StoreStandardAreaRate $request, $id)
    {
        $sar = StandardAreaRate::findOrFail($id);
        $sar->areaFrom = $request->areaFrom;
        $sar->areaTo = $request->areaTo;
        $sar->amount = $request->amount;
        $sar->save();

        return $area;
    }

	


	public function destroy($id)
	{

		$sar = StandardAreaRate::findOrFail($id);
        $sar->delete();
	}
}
