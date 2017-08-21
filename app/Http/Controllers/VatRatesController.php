<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VatRate;
use App\Http\Request\StoreVatRate;

class VatRatesController extends Controller
{
	public function index()
	{
		$vrs = \DB::select("SELECT * FROM vat_rates WHERE dateEffective < NOW() ORDER BY dateEffective");
		$current = $vrs[count($vrs) -1 ];

		\DB::update('UPDATE vat_rates SET currentRate = 0 WHERE id != ' . $current->id);
		\DB::update('UPDATE vat_rates SET currentRate = 1 WHERE id = ' . $current->id);

		$vat_rate = \DB::table('vat_rates')
		->select('rate')
		->where('currentRate', '=', 1)
		->get();

		if(count($vat_rate) == 0){
			$vat_rate[0]->rate = 0;
		}

		return view('admin/utilities.vat_rate_index', compact(['vat_rate']));
	}


	public function store(Request $request)
	{

		$vr = VatRate::create($request->all());
		return $vr;
	}

	public function update(Request $request, $id)
	{
		$vat_rate = VatRate::findOrFail($id);
		$vat_rate ->rate = $request->rate;
		$vat_rate ->currentRate = $request->currentRate;
		$vat_rate ->dateEffective = $request->dateEffective;
		$vat_rate ->description = $request->description;
		$vat_rate ->save();

		return $vat_rate;
	}


	public function destroy($id)
	{
		$vat_rate = VatRate::findOrFail($id);
		$vat_rate->delete();

	}
}
