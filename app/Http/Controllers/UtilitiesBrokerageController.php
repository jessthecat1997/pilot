<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UtilityType;
use Illuminate\Support\Facades\DB;
class UtilitiesBrokerageController extends Controller
{
    public function index()
	{
		$brokerage_utility = DB::table('utility_types')
		->select('bank_charges', 'other_charges', 'id')
		->get();

		return view('admin/utilities.brokerage_utility_index', compact(['brokerage_utility']));
	}




	public function update(Request $request, $id)
	{
		$brokerage_utility = UtilityType::findOrFail($id);
		$brokerage_utility->bank_charges = $request->bank_charges;
		$brokerage_utility->other_charges = $request->other_charges;
		$brokerage_utility->save();

		return $brokerage_utility;
	}
}
