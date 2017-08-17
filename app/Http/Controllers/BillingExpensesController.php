<?php

namespace App\Http\Controllers;
use App\ConsigneeServiceOrderHeader;
use App\BillingInvoiceHeader;
use App\BillingExpense;
use Illuminate\Http\Request;

class BillingExpensesController extends Controller
{
	public function store(Request $request)
	{
		for($i = 0; $i<count($request->bill_id); $i++)
		{
			$billing_header = new BillingInvoiceHeader;
			$billing_header->so_head_id = $request->so_head_id;
			$billing_header->vatRate = $request->vatRate;
			$billing_header->date_billed = $request->date_billed;
			$billing_header->override_date = $request->override_date;
			$billing_header->due_date = $request->due_date;
			$billing_header->save();
			$billing_expense = new BillingExpense;
			$billing_expense->bill_id = $request->bill_id[$i];
			$billing_expense->description = $request->description[$i];
			$billing_expense->amount = $request->amount[$i];
			$billing_expense->tax = $request->tax[$i];
			$billing_expense->bi_head_id = $request->bi_head_id;
			$billing_expense->save();
		}
	}
}
