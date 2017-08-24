<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Facades\Datatables;
use App\Billing;
use App\BillingInvoiceDetails;
use App\Charge;
use App\BillingInvoiceHeader;
use App\ConsigneeServiceOrderHeader;
use App\Http\Requests\StoreBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class BillingDetailsController extends Controller
{
	public function index(Request $request)
	{
		return view('billing/billing_index');
	}
	public function show_index(Request $request, $id)
	{
		$so_head_id = $id;
		return view('billing/billing_index', compact('so_head_id'));
	}
	public function show(Request $request, $id)
	{

		$bills = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('billing_invoice_headers', 'consignee_service_order_headers.id', '=', 'billing_invoice_headers.so_head_id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->select('consignee_service_order_headers.id', 'companyName', 'service_order_types.name', DB::raw('CONCAT(b_address, ", ", b_city, ", ", b_st_prov) AS address'))
		->where('consignee_service_order_headers.id', '=', $id)
		->get();

		$so_head_id = $id;

		$vat = DB::table('vat_rates')
		->select(DB::raw('CONCAT(TRUNCATE(rate,2)) as rates'))
		->get();

		return view('billing/billing_view', compact(['bills', 'so_head_id', 'vat']));

	}
	public function get_detail(Request $request){
		$charge = DB::table('charges')
		->select('amount')
		->where('charges.id', '=', $request->id)
		->get();

		return $charge;
	}
	public function show_billing(Request $request, $id)
	{
		$bill_revs = DB::table('charges')
		->select('id','name', 'amount')
		->where('bill_type', '=', 'R')
		->get();

		$bill_exps = DB::table('charges')
		->select('id','name', 'amount')
		->where('bill_type', '=', 'E')
		->get();


		$bills = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('billing_invoice_headers', 'consignee_service_order_headers.id', '=', 'billing_invoice_headers.so_head_id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->select('consignee_service_order_headers.id', 'companyName', 'service_order_types.name', DB::raw('CONCAT(b_address, ", ", b_city, ", ", b_st_prov) AS address'), 'isRevenue', 'status')
		->where('billing_invoice_headers.id', '=', $id)
		->get();


		$so_head_id = $id;

		$vat = DB::table('vat_rates')
		->select(DB::raw('CONCAT(TRUNCATE(rate,2)) as rates'))
		->get();

		$rev_vat = DB::table('billing_invoice_headers')
		->join('billing_invoice_details', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('charges', 'billing_invoice_details.charge_id', '=', 'charges.id')
		->select(DB::raw('CONCAT(TRUNCATE(vatRate,2)) as rates'), DB::raw('CONCAT(TRUNCATE(SUM((billing_invoice_details.amount * (vatRate/100))),2)) as Total'))
		->where([
			['billing_invoice_details.bi_head_id', '=', $id],
			['charges.bill_type', '=', 'R']
			])
		->get();

		$rev_total = DB::table('billing_invoice_details')
		->join('billing_invoice_headers','billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('charges', 'billing_invoice_details.charge_id', '=', 'charges.id')
		->select(DB::raw('CONCAT(TRUNCATE(SUM(billing_invoice_details.amount + (billing_invoice_details.amount * vatRate/100)),2)) as Total'))
		->where([
			['billing_invoice_details.bi_head_id', '=', $id],
			['charges.bill_type', '=', 'R']
			])
		->get();

		$rev_bill = DB::table('billing_invoice_details')
		->join('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('charges', 'billing_invoice_details.charge_id', '=', 'charges.id')
		->select('charges.name', 'billing_invoice_details.amount')
		->where([
			['billing_invoice_details.bi_head_id', '=', $id],
			['charges.bill_type', '=', 'R']
			])
		->get();

		$exp_vat = DB::table('billing_invoice_headers')
		->join('billing_invoice_details', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('charges', 'billing_invoice_details.charge_id', '=', 'charges.id')
		->select(DB::raw('CONCAT(TRUNCATE(vatRate,2)) as rates'), DB::raw('CONCAT(TRUNCATE(SUM((billing_invoice_details.amount * (vatRate/100))),2)) as Total'))
		->where([
			['billing_invoice_details.bi_head_id', '=', $id],
			['charges.bill_type', '=', 'E']
			])
		->get();

		$exp_total = DB::table('billing_invoice_details')
		->join('billing_invoice_headers','billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('charges', 'billing_invoice_details.charge_id', '=', 'charges.id')
		->select(DB::raw('CONCAT(TRUNCATE(SUM(billing_invoice_details.amount + (billing_invoice_details.amount * vatRate/100)),2)) as Total'))
		->where([
			['billing_invoice_details.bi_head_id', '=', $id],
			['charges.bill_type', '=', 'E']
			])
		->get();

		$exp_bill = DB::table('billing_invoice_details')
		->join('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('charges', 'billing_invoice_details.charge_id', '=', 'charges.id')
		->select('charges.name', 'billing_invoice_details.amount')
		->where([
			['billing_invoice_details.bi_head_id', '=', $id],
			['charges.bill_type', '=', 'E']
			])
		->get();

		return view('billing/billing_create', compact(['vat', 'bills','bill_revs', 'bill_exps','so_head_id', 'rev_vat', 'rev_total', 'rev_bill','exp_vat', 'exp_total', 'exp_bill']));
		
	}
	public function billing_invoice(Request $request)
	{
		$bill_hist = DB::table('billing_invoice_headers')
		->join('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->select('billing_invoice_headers.id', 'isRevenue', 'due_date')
		->get();

		return Datatables::of($bill_hist)
		->addColumn('action', function ($hist) {
			return
			'<a href = "/billing/'. $hist->id .'/create" style="margin-right:10px; width:100;" class = "btn btn-md but bill_inv">Select</a>';
		})
		->make(true);
	}
	public function billing_history(Request $request)
	{
		$bill_history = DB::table('billing_invoice_headers')
		->join('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->select('billing_invoice_headers.id', 'isRevenue', 'due_date')
		->get();

		return Datatables::of($bill_history)
		->addColumn('action', function ($history) {
			return
			'<a href = "/billing/'. $history->id .'/create" style="margin-right:10px; width:100;" class = "btn btn-md but bill_inv">Select</a>';
		})
		->make(true);
	}
	public function store(Request $request)
	{
		for($i = 0; $i<count($request->charge_id); $i++)
		{
			$billing_revenue = new BillingInvoiceDetails;
			$billing_revenue->charge_id = $request->charge_id[$i];
			$billing_revenue->description = $request->description[$i];
			$billing_revenue->amount = $request->amount[$i];
			$billing_revenue->tax = $request->tax;
			$billing_revenue->bi_head_id = $request->bi_head_id;
			$billing_revenue->save();
		}
	}
	public function bill_pdf(Request $request, $id)
	{
		$bills = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->join('billing_invoice_headers', 'consignee_service_order_headers.id', '=', 'billing_invoice_headers.so_head_id')
		->select('consignee_service_order_headers.id','companyName','service_order_types.name', DB::raw('CONCAT(b_address, ", ", b_city, ", ", b_st_prov) AS address'),'TIN', 'businessStyle', 'billing_invoice_headers.created_at')
		->where('consignee_service_order_headers.id', '=', $id)
		->get();

		$billing_header =  BillingInvoiceHeader::all()->last();
		$number = $billing_header->id;
		$parts = DB::table('billing_invoice_details')
		->join('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('charges','billing_invoice_details.charge_id', '=', 'charges.id')
		->select('name', DB::raw('CONCAT(TRUNCATE(billing_invoice_details.amount + (billing_invoice_details.amount * tax/100),2)) as Total'))
		->where('billing_invoice_headers.so_head_id', '=', $id)
		->get();

		$vat = DB::table('billing_invoice_headers')
		->join('billing_invoice_details', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->select(DB::raw('CONCAT(TRUNCATE(vatRate,2)) as rates'), DB::raw('CONCAT(TRUNCATE(SUM((amount * (vatRate/100))),2)) as Total'))
		->where('billing_invoice_headers.so_head_id', '=', $id)
		->get();

		$total = DB::table('billing_invoice_details')
		->join('billing_invoice_headers','billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->select(DB::raw('CONCAT(TRUNCATE(SUM(amount + (amount * vatRate/100)),2)) as Total'))
		->where('billing_invoice_headers.so_head_id', '=', $id)
		->get();

		$pdf = PDF::loadView('pdf_layouts.bill_invoice_pdf', compact(['parts', 'bills', 'number', 'total','vat']));
		return $pdf->stream();
	}

}
