<?php

namespace App\Http\Controllers;

use App\PaymentMode;
use App\Payment;
use App\PaymentHistory;
use App\ConsigneeServiceOrderHeader;
use App\BillingInvoiceHeader;
use App\Http\Requests\StorePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use PDF;
use Yajra\Datatables\Facades\Datatables;

class PaymentsController extends Controller
{
	public function index()
	{
		return view('payment/payment_index');
	}
	public function show(Request $request, $id)
	{
		$pays = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->select('consignee_service_order_headers.id', 'companyName', 'service_order_types.name', 'address')
		->where('consignee_service_order_headers.id', '=', $id)
		->get();

		$so_head_id = $id;

		$paid = DB::table('payments')
		->join('billing_invoice_headers', 'payments.bi_head_id', '=', 'billing_invoice_headers.id')
		->select(DB::raw('CONCAT(SUM(amount)) as Total'))
		->orderBy('payments.id', 'desc')
		->where('billing_invoice_headers.so_head_id', '=', $id)
		->get();

		$total = DB::table('billing_invoice_details')
		->select(DB::raw('CONCAT(SUM(amount)) as Total'))
		->where('billing_invoice_details.bi_head_id', '=', $id)
		->get();
		return view('payment/payment_create', compact(['pays', 'so_head_id','paid', 'total']));

	}
	public function payments_table(Request $request, $id)
	{
		$history = DB::table('payments')
		->select('id', 'amount', 'created_at', 'description')
		->orderBy('id', 'desc')
		->get();
		return Datatables::of($history)
		->make(true);
	}
	public function store(StorePayment $request)
	{
		$new_payment = new Payment;

		$new_payment->amount = $request->amount;
		$new_payment->description = $request->description;
		$new_payment->bi_head_id = $request->bi_head_id;
		$new_payment->save();
	}
	public function update(Request $request, $id)
	{
		$csh = BillingInvoiceHeader::findOrFail($id);
		$csh->status = $request->status;
		$csh->save();

		return $csh;
	}
	public function payment_pdf(Request $request, $id)
	{
		$payments = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->join('billing_invoice_headers', 'consignee_service_order_headers.id', '=', 'billing_invoice_headers.so_head_id')
		->select('billing_invoice_headers.id','companyName','service_order_types.name', 'address','TIN', 'businessStyle', 'billing_invoice_headers.created_at')
		->where('billing_invoice_headers.id', '=', $id)
		->get();

		$rev = DB::table('billing_revenues')
		->join('billings', 'billing_revenues.bill_id', '=', 'billings.id')
		->select('name','amount')
		->where('billing_revenues.bi_head_id','=', $id);

		$exp = DB::table('billing_expenses')
		->join('billings', 'billing_expenses.bill_id', '=', 'billings.id')
		->select('name','amount')
		->where('billing_expenses.bi_head_id','=', $id)
		->union($rev)
		->get();

		$pdf = PDF::loadView('pdf_layouts.payment_receipt', compact('payments', 'exp'));
		return $pdf->stream();
	}
}
