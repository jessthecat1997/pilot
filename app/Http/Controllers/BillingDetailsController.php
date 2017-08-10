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
	public function index()
	{
		return view('billing/bill_so_index');
	}
	public function show(Request $request, $id)
	{

		$bills = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->select('consignee_service_order_headers.id', 'companyName', 'service_order_types.name', 'address')
		->where('consignee_service_order_headers.id', '=', $id)
		->get();

		$delivery = DB::table('delivery_billings')
		->leftjoin('charges', 'delivery_billings.charges_id', '=', 'charges.id')
		->select('charges.description', 'delivery_billings.amount')
		->where('del_head_id', '=', $id)
		->get();

		$so_head_id = $id;
		

		return view('billing/billing_index', compact(['bills', 'delivery', 'so_head_id']));

	}
	public function show_billing(Request $request, $id)
	{
		$billings = Billing::all();
		// $total_bills = DB::table('billing_invoice_details')
		// ->leftjoin('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		// ->select(DB::raw('CONCAT(TRUNCATE(SUM(billing_invoice_details.amount - (billing_invoice_details.amount * billing_invoice_details.discount/100)),2)) as Total'))
		// ->where('billing_invoice_headers.so_head_id','=',$request)
		// ->get();

		$charges = Charge::all();

		$bills = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->select('consignee_service_order_headers.id', 'companyName', 'service_order_types.name', 'address')
		->where('consignee_service_order_headers.id', '=', $id)
		->get();

		$so_head_id = $id;

		return view('billing/bills_index', compact(['bill_invoice', 'bills', 'billings','bill_counts', 'total_bills', 'charges', 'delivery', 'so_head_id']));
		
	}
	public function billing_invoice(Request $request)
	{
		$bill_hists = DB::table('billing_invoice_headers')
		->select('id', 'vatRate', 'date_billed', 'due_date')
		->where('so_head_id', '=', $request->so_head_id)
		->get();

		return Datatables::of($bill_hists)
		->addColumn('action', function ($hist) {
			return
			'<a href = "/billing/'. $hist->id .'/show_pdf" style="margin-right:10px; width:100;" class = "btn btn-md btn-info bill_inv">View Invoice</a>';
		})
		->make(true);
		return view('billing/billing_index', compact(['billings']));
	}
	public function store(Request $request)
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
	public function bill_pdf(Request $request, $id)
	{
		$bills = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->join('billing_invoice_headers', 'consignee_service_order_headers.id', '=', 'billing_invoice_headers.so_head_id')
		->select('billing_invoice_headers.id','companyName','service_order_types.name', 'address','TIN', 'businessStyle', 'billing_invoice_headers.created_at')
		->where('billing_invoice_headers.id', '=', $id)
		->get();

		$billing_header =  BillingInvoiceHeader::all()->last();
		$particulars = DB::table('billings')
		->leftjoin('billing_invoice_details', 'billings.id', '=', 'billing_invoice_details.billings_id')
		->leftjoin('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->leftjoin('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->leftjoin('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->select('billings.name', DB::raw('CONCAT(TRUNCATE(billing_invoice_details.amount - (billing_invoice_details.amount * billing_invoice_details.discount/100),2)) as Total'))
		->where('billing_invoice_headers.id','=',$billing_header->id)
		->get();

		$br_rc = DB::table('refundable_charges')
		->join('consignee_service_order_headers', 'refundable_charges.so_head_id', '=', 'consignee_service_order_headers.id')
		->select('refundable_charges.description', 'amount')
		->where('consignee_service_order_headers.id', '=', $billing_header->id)
		->get();

		$totalbill = DB::table('billing_invoice_details')
		->leftjoin('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->leftjoin('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->select(DB::raw('CONCAT(TRUNCATE(SUM(billing_invoice_details.amount - (billing_invoice_details.amount * billing_invoice_details.discount/100)),2)) as Total'))
		->where('billing_invoice_headers.so_head_id','=',$billing_header->id)
		->get();
		
		$pdf = PDF::loadView('pdf_layouts.bill_invoice_pdf', compact(['particulars', 'totalbill', 'bills', 'br_rc']));
		return $pdf->stream();
	}
	
}
