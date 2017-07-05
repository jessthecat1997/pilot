<?php

namespace App\Http\Controllers;

use App\Billing;
use App\BillingInvoiceDetails;
use App\BillingInvoiceHeader;
use App\ConsigneeServiceOrderHeader;
use App\Http\Requests\StoreBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingDetailsController extends Controller
{
	public function index()
	{

		$billings = Billing::all();
		return view('billing/billing_index', compact(['billings']));
	}
	public function store(StoreBilling $request)
	{
		$billing_header = new BillingInvoiceHeader;
		$billing_header->so_head_id = $request->so_head_id;
		$billing_header->paymentAllowance = $request->paymentAllowance;
		$billing_header->save();

		$billing_header =  BillingInvoiceHeader::all()->last();

		for($i = 0; $i<count($request->billings_id); $i++)
		{
			$billing_detail = new BillingInvoiceDetails;
			$billing_detail->billings_id = $request->billings_id[$i];
			$billing_detail->amount = $request->amount[$i];
			$billing_detail->discount = $request->discount[$i];
			$billing_detail->bi_head_id = $billing_header->id;
			$billing_detail->save();
		}
	}
}
