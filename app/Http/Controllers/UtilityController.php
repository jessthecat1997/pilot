<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UtilityType;
use Illuminate\Support\Facades\DB;
class UtilityController extends Controller
{
    public function index()
	{
		$utility = \App\UtilityType::all();

		return view('admin/utilities.utility_index', compact(['utility']));
	}




	public function update(Request $request, $id)
	{
		$utility = UtilityType::findOrFail($id);
		$utility->bank_charges = $request->bank_charges;
		$utility->other_charges = $request->other_charges;
		$utility->insurance_gc = $request->insurance_gc;
		$utility->insurance_c = $request->insurance_c;
		$utility->company_name = $request->company_name;
		$utility->company_address = $request->company_address;
		$utility->company_tin = $request->company_tin;
		$utility->company_contact = $request->company_contact;
		$utility->save();

		return $utility;
	}
}