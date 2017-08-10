<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Http\Requests\StoreBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingsController extends Controller
{
	public function index()
	{

		$billings = Billing::all();
		return view('admin/maintenance/billing_index', compact(['billings']));

	}
	public function store(StoreBilling $request)
	{
		$b = Billing::create($request->all());
		return $b;
	}
	public function update(StoreBilling $request, $id)
	{
		$bill = Billing::findOrFail($id);
		$bill->bill_type = $request->bill_type;
		$bill->name = $request->name;
		$bill->description = $request->description;
		$bill->save();
		return $bill;
	}


	public function destroy($id)
	{
		$bill = Billing::findOrFail($id);
		$bill->delete();

	}
}
