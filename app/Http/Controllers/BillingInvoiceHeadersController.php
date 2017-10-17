<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BillingInvoiceHeader;
use Illuminate\Support\Facades\DB;

class BillingInvoiceHeadersController extends Controller
{
	public function index(Request $request)
	{
		return view('billing/billing_select');
	}
	public function show(Request $request, $id)
	{
		$bills = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->select('consignee_service_order_headers.id', 'companyName', 'service_order_types.name', DB::raw('CONCAT(b_address, ", ", b_city, ", ", b_st_prov) AS address'))
		->where('consignee_service_order_headers.id', '=', $id)
		->get();

		$so_head_id = $id;

		$vat = DB::table('vat_rates')
		->select(DB::raw('CONCAT(TRUNCATE(rate,2)) as rates'))
		->get();

		return view('billing/billing_select', compact(['bills', 'so_head_id', 'vat']));
	}
	public function store(Request $request)
	{
		$billing_header = new BillingInvoiceHeader;
		$billing_header->so_head_id = $request->so_head_id;
		$billing_header->isRevenue = 1;
		$billing_header->isVatFree = 0;
		$billing_header->isVoid = 0;
		$billing_header->vatRate = $request->vatRate;
		$billing_header->status = $request->status;
		$billing_header->date_billed = $request->date_billed;
		$billing_header->override_date = $request->override_date;
		$billing_header->due_date = $request->due_date;
		$billing_header->save();

		$audit = new \App\AuditTrail;
		$audit->user_id = \Auth::user()->id;
		$audit->description = "Creaye invoice";
		$audit->save();
	}
	public function update(Request $request)
	{
		$csh = BillingInvoiceHeader::findOrFail($request->bi_head);
		$csh->vatRate = $request->vatRate;
		$csh->date_billed = $request->date_billed;
		$csh->due_date = $request->due_date;
		$csh->save();

		$audit = new \App\AuditTrail;
		$audit->user_id = \Auth::user()->id;
		$audit->description = "Update invoice";
		$audit->save();

		return $csh;
	}
}
