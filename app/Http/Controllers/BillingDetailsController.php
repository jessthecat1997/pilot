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
		$billing_header->vatRate = $request->vatRate;
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

	public function billing_pdf($request)
	{
		$bills = DB::table('consignee_service_order_details')
		->join('consignee_service_order_headers', 'consignee_service_order_details.so_headers_id', '=', 'consignee_service_order_headers.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->join('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->join('billing_invoice_headers', 'consignee_service_order_headers.id', '=', 'billing_invoice_headers.so_head_id')
		->select('consignee_service_order_details.id','companyName','service_order_types.description', 'address', 'billing_invoice_headers.created_at','TIN', 'businessStyle')
		->where('billing_invoice_headers.id', '=', $request)
		->get();

		$particulars = DB::table('billings')
		->leftjoin('billing_invoice_details', 'billings.id', '=', 'billing_invoice_details.billings_id')
		->leftjoin('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->leftjoin('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->leftjoin('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->select('description', DB::raw('CONCAT(TRUNCATE(billing_invoice_details.amount - (billing_invoice_details.amount * billing_invoice_details.discount/100),2)) as Total'))
		->where('billing_invoice_headers.so_head_id','=',$request)
		->get();

		$totalamt = DB::table('billing_invoice_details')
		->leftjoin('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->select(DB::raw('CONCAT(TRUNCATE(SUM(billing_invoice_details.amount - (billing_invoice_details.amount * billing_invoice_details.discount/100)),2)) as Total'))
		->where('billing_invoice_headers.so_head_id','=',$request)
		->get();
		$pdf = PDF::loadView('pdf_layouts.billing_invoice_pdf', compact(['particulars', 'totalamt', 'bills']));
		return $pdf->stream();
	}
	public function bill_pdf($request)
	{
		$bills = DB::table('consignee_service_order_details')
		->join('consignee_service_order_headers', 'consignee_service_order_details.so_headers_id', '=', 'consignee_service_order_headers.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->join('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->join('billing_invoice_headers', 'consignee_service_order_headers.id', '=', 'billing_invoice_headers.so_head_id')
		->select('consignee_service_order_details.id','companyName','service_order_types.description', 'address', 'billing_invoice_headers.created_at','TIN', 'businessStyle')
		->where('billing_invoice_headers.id', '=', $request)
		->get();

		$particulars = DB::table('billings')
		->leftjoin('billing_invoice_details', 'billings.id', '=', 'billing_invoice_details.billings_id')
		->leftjoin('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->leftjoin('refundable_charges', 'billing_invoice_headers.id', '=', 'refundable_charges.so_head_id')
		->leftjoin('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->leftjoin('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->select('billings.description','refundable_charges.description','refundable_charges.amount', DB::raw('CONCAT(TRUNCATE(billing_invoice_details.amount - (billing_invoice_details.amount * billing_invoice_details.discount/100),2)) as Total'))
		->where('billing_invoice_headers.id','=',$request)
		->get();

		$totalamt = DB::table('billing_invoice_details')
		->leftjoin('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->select(DB::raw('CONCAT(TRUNCATE(SUM(billing_invoice_details.amount - (billing_invoice_details.amount * billing_invoice_details.discount/100)),2)) as Total'))
		->where('billing_invoice_headers.id','=',$request)
		->get();
		
		$pdf = PDF::loadView('pdf_layouts.bill_invoice_pdf', compact(['particulars', 'totalamt', 'bills']));
		return $pdf->stream();
	}
	
=======
>>>>>>> parent of 37d9d9b... Billing views and controllers
}
