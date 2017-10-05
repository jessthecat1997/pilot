<?php

namespace App\Http\Controllers;

use App\PaymentMode;
use App\Payment;
use App\PaymentHistory;
use App\ConsigneeServiceOrderHeader;
use App\BillingInvoiceHeader;
use App\Cheque;
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
		->join('billing_invoice_headers', 'consignee_service_order_headers.id', '=', 'billing_invoice_headers.so_head_id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->select(
			'billing_invoice_headers.id as bi_head',
			'consignee_service_order_headers.id',
			'companyName', 'service_order_types.name',
			DB::raw('CONCAT(firstName, " ", lastName) as con_name'),
			DB::raw('CONCAT(b_address, ", ", b_city, ", ", b_st_prov) AS address'),
			'consignees_id as con_id',
			'billing_invoice_headers.status'
			)
		->where('billing_invoice_headers.id', '=', $id)
		->get();

		$so_head_id = $id;

		$paid = DB::table('payments')
		->join('billing_invoice_headers', 'payments.bi_head_id', '=', 'billing_invoice_headers.id')
		->select(DB::raw('CONCAT(SUM(amount)) as total'))
		->orderBy('payments.id', 'desc')
		->where('payments.bi_head_id', '=', $id)
		->get();

		$deposits = DB::table('consignee_deposits')
		->select('amount', 'currentBalance', 'created_at', 'id')
		->where('consignees_id', '=', $pays[0]->con_id)
		->where('currentBalance', '>', 0)
		->get();
		
		$total = DB::select('SELECT t.id, 
			
			(CASE t.isRevenue
			WHEN t.isRevenue = 1 THEN "Revenue"
			WHEN t.isRevenue = 0 THEN "Expense"
			END) as isRevenue,	
			CONCAT("Php ", (ROUND(((p.total * t.vatRate)/100), 2) + p.total)) as Total,
			ROUND(((p.total * t.vatRate)/100), 2) + p.total as totall,
			pay.totpay,
			(ROUND(((p.total * t.vatRate)/100), 2) + p.total) - ((pay.totpay + dpay.totdpay)) AS balance,
			DATE_FORMAT(t.due_date, "%M %d, %Y") as due_date,
			t.status,
            dpay.totdpay


			FROM billing_invoice_headers t LEFT JOIN 
			(
			SELECT bi_head_id, SUM(amount) total
			FROM billing_invoice_details
			GROUP BY bi_head_id
			) p 
			ON t.id = p.bi_head_id

			LEFT JOIN

			(
			SELECT bi_head_id, SUM(amount) totpay
			FROM payments
			GROUP BY bi_head_id
			) pay

			ON t.id = pay.bi_head_id
            
            LEFT JOIN
            (
             SELECT bi_head_id, SUM(amount) totdpay
             FROM deposit_payments
             GROUP BY bi_head_id
            ) dpay
            
            ON t.id = dpay.bi_head_id
			WHERE t.id = ?
			', [$id]);

		$allowance = DB::table('utility_types')
		->select('id','payment_allowance')
		->get();

		return view('payment/payment_create', compact(['pays', 'so_head_id','paid', 'total', 'deposits', 'allowance']));

	}
	public function payments_table(Request $request, $id)
	{
		$history = DB::select(
			'SELECT CONCAT("Payment: ", id) as record, CONCAT("Php ",amount) as amount, created_at, description, p.id as id, CONCAT("1") as type FROM payments as p  WHERE p.bi_head_id = ?
			UNION 
			(
			SELECT CONCAT("Deposit Payment: ", id) as record, CONCAT("Php ", amount) as amount, created_at, description, dp.id as id, CONCAT("2") as type FROM deposit_payments as dp WHERE dp.bi_head_id = ?
			)
			', [$id, $id]
			);
		return Datatables::of($history)
		->addColumn('action', function ($hist) {
			return
			'<button value = "'. $hist->id .'" class = "btn btn-md btn-primary payment_receipt"><span class="fa fa-print"></span></button>
			<input type = "hidden" class = "type" value = "' . $hist->type . '" />';
		})
		->make(true);
	}
	public function bills_table(Request $request, $id)
	{
		$billings = DB::table('billing_invoice_details')
		->join('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('charges', 'billing_invoice_details.charge_id', '=', 'charges.id')
		->select('charges.name', DB::raw('CONCAT(TRUNCATE(billing_invoice_details.amount + (billing_invoice_details.amount * vatRate/100),2)) as Total'))
		->where('billing_invoice_headers.id', '=', $id)
		->get();
		return Datatables::of($billings)
		->addColumn('action', function ($b) {
			return
			'<button value = "'. $b->Total .'" style="margin-right:10px; width:100;" class = "btn but make_payment" data-toggle="modal" data-target="#billModal">Make Payment</button>';
		})
		->make(true);
	}
	public function store(StorePayment $request)
	{
		$new_payment = new Payment;

		$new_payment->amount = $request->amount;
		$new_payment->description = $request->description;
		$new_payment->isCheque = $request->isCheque;
		$new_payment->bi_head_id = $request->bi_head_id;
		$new_payment->utility_id = $request->utility_id;
		$new_payment->save();
	}
	public function update(Request $request, $id)
	{
		$csh = BillingInvoiceHeader::findOrFail($id);
		$csh->status = $request->status;
		$csh->save();

		return $csh;
	}
	public function payment_pdf(Request $request)
	{

		$payment = \App\Payment::findOrFail($request->payment_id);

		$bill = DB::select('
			SELECT t.id, 
			con.firstName,
			con.lastName,
			con.TIN,
			con.address,
			con.businessStyle,
			t.id as bill_id,
			t.isRevenue as billtype,


			(CASE t.isRevenue
			WHEN t.isRevenue = 1 THEN "Revenue"
			WHEN t.isRevenue = 0 THEN "Expense"
			END) as isRevenue,	
			CONCAT("Php ", (ROUND(((p.total * t.vatRate)/100), 2) + p.total)) as Total,
			ROUND(((p.total * t.vatRate)/100), 2) + p.total as totall,
			pay.totpay,
			(ROUND(((p.total * t.vatRate)/100), 2) + p.total) - ((pay.totpay + dpay.totdpay)) AS balance,
			DATE_FORMAT(t.due_date, "%M %d, %Y") as due_date,
			t.status,
            dpay.totdpay


			FROM billing_invoice_headers t LEFT JOIN 
			(
			SELECT bi_head_id, SUM(amount) total
			FROM billing_invoice_details
			GROUP BY bi_head_id
			) p 
			ON t.id = p.bi_head_id

			LEFT JOIN

			(
			SELECT bi_head_id, SUM(amount) totpay
			FROM payments
			GROUP BY bi_head_id
			) pay

			ON t.id = pay.bi_head_id
            
            LEFT JOIN
            (
             SELECT bi_head_id, SUM(amount) totdpay
             FROM deposit_payments
             GROUP BY bi_head_id
            ) dpay
            
            ON t.id = dpay.bi_head_id
            
            JOIN consignee_service_order_headers as so 
            
            on so.id = t.so_head_id
            
            JOIN consignees as con
            
            on con.id = so.consignees_id

            where t.id = ?
			', [$payment->bi_head_id]);

		$pdf = PDF::loadView('pdf_layouts.payment_receipt', compact(['payment','bill']));
		return $pdf->stream();
	}

	public function payment_deposit_pdf(Request $request, $id)
	{
		$payment = \App\DepositPayment::findOrFail($request->payment_id);

		$bill = DB::select('
			SELECT t.id, 
			con.firstName,
			con.lastName,
			con.TIN,
			con.address,
			con.businessStyle,
			t.id as bill_id,
			t.isRevenue as billtype,


			(CASE t.isRevenue
			WHEN t.isRevenue = 1 THEN "Revenue"
			WHEN t.isRevenue = 0 THEN "Expense"
			END) as isRevenue,	
			CONCAT("Php ", (ROUND(((p.total * t.vatRate)/100), 2) + p.total)) as Total,
			ROUND(((p.total * t.vatRate)/100), 2) + p.total as totall,
			pay.totpay,
			(ROUND(((p.total * t.vatRate)/100), 2) + p.total) - ((pay.totpay + dpay.totdpay)) AS balance,
			DATE_FORMAT(t.due_date, "%M %d, %Y") as due_date,
			t.status,
            dpay.totdpay


			FROM billing_invoice_headers t LEFT JOIN 
			(
			SELECT bi_head_id, SUM(amount) total
			FROM billing_invoice_details
			GROUP BY bi_head_id
			) p 
			ON t.id = p.bi_head_id

			LEFT JOIN

			(
			SELECT bi_head_id, SUM(amount) totpay
			FROM payments
			GROUP BY bi_head_id
			) pay

			ON t.id = pay.bi_head_id
            
            LEFT JOIN
            (
             SELECT bi_head_id, SUM(amount) totdpay
             FROM deposit_payments
             GROUP BY bi_head_id
            ) dpay
            
            ON t.id = dpay.bi_head_id
            
            JOIN consignee_service_order_headers as so 
            
            on so.id = t.so_head_id
            
            JOIN consignees as con
            
            on con.id = so.consignees_id

            where t.id = ?
			', [$payment->bi_head_id]);

		$pdf = PDF::loadView('pdf_layouts.payment_receipt', compact(['payment','bill']));
		return $pdf->stream();
	}
	public function verify_cheque(Request $request)
	{
		$chq = Cheque::findOrFail($request->id);
		$chq->isVerify = $request->isVerify;
		$chq->save();

		return $csh;
	}
	public function storeCheque(Request $request)
	{
		$new_chq = new Cheque;
		$new_chq->chequeNumber = $request->chequeNumber;
		$new_chq->bankName = $request->bankName;
		$new_chq->amount = $request->amount;
		$new_chq->isVerify = $request->isVerify;
		$new_chq->bi_head_id = $request->bi_head_id;
		$new_chq->save();
	}
}
