<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UtilityType;
use App\VatRate;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUtility;
class UtilityController extends Controller
{
	public function index()
	{
		$utility = \App\UtilityType::all();
		$vat = \DB::table('vat_rates')
		->where('currentRate', '=', 1)
		->get();

		return view('admin/utilities.utility_index', compact(['utility' , 'vat']));
	}




	public function update(StoreUtility $request, $id)
	{
		$utility = UtilityType::findOrFail($id);
		if($request->logo != null){
			$input = $request->all();
			$input['image'] = "pilotlogo.". $request->logo->getClientOriginalExtension();
			$utility->company_logo = "/images/pilotlogo." . $request->logo->getClientOriginalExtension();
			$request->logo->move(public_path('images'), $input['image']);
		}
		


		
		$utility->bank_charges = $request->bank_charges;
		$utility->other_charges = $request->other_charges;
		$utility->insurance_gc = $request->insurance_gc;
		$utility->insurance_c = $request->insurance_c;
		$utility->company_name = $request->company_name;
		$utility->company_address = $request->company_address;
		$utility->company_tin = $request->company_tin;
		$utility->company_contact = $request->company_contact;
		$utility->payment_allowance = $request->payment_allowance;
		$utility->save();



		$vat = VatRate::findOrFail($id);
		$vat->rate = $request->rate;
		$vat->save();

		return $utility;

	}
}
