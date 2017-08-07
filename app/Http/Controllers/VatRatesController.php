<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VatRate;
use App\Http\Request\StoreVatRate;

class VatRatesController extends Controller
{
	public function index()
	{
		return view('admin/utilities.vat_rate_index');
	}


	public function store( $request)
	{

		$vr = VatRate::create($request->all());
		return $vr;
	}

	public function update(StoreVatRate $request, $id)
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
