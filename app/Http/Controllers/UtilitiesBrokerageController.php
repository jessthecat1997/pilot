<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UtilityType;
use Illuminate\Support\Facades\DB;
class UtilitiesBrokerageController extends Controller
{
    public function index()
	{
		$utility = \App\UtilityType::all();

		return view('admin/utilities.brokerage_utility_index', compact(['utility']));
	}




	public function update(Request $request, $id)
	{
		$utility = UtilityType::findOrFail($id);
		$utility->bank_charges = $request->bank_charges;
		$utility->other_charges = $request->other_charges;
		$utility->insurance_gc = $request->insurance_gc;
		$utility->insurance_c = $request->insurance_c;
		$utility->save();

		return $utility;
	}
}
