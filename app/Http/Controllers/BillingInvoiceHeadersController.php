<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BillingInvoiceHeader;

class BillingInvoiceHeadersController extends Controller
{
	public function store(Request $request)
	{
		$billing_header = new BillingInvoiceHeader;
		$billing_header->so_head_id = $request->so_head_id;
		$billing_header->isRevenue = 1;
		$billing_header->vatRate = $request->vatRate;
		$billing_header->status = $request->status;
		$billing_header->date_billed = $request->date_billed;
		$billing_header->override_date = $request->override_date;
		$billing_header->due_date = $request->due_date;
		$billing_header->save();
	}
}
