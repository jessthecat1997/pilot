<?php

namespace App\Http\Controllers;

use App\Cheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

class ChequesController extends Controller
{
	public function index()
	{

		return view('payment.cheque_index');
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

		$cheques = DB::table('cheques')
		->join('billing_invoice_headers', 'cheques.bi_head_id', '=', 'billing_invoice_headers.id')
		->select('chequeNumber','bankName', 'amount')
		->where('cheques.bi_head_id', '=', $id)
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


		return view('payment/cheque_payment', compact(['pays', 'so_head_id','paid', 'total', 'deposits', 'cheques']));
	}
	public function update(Request $request)
	{
		$chq = Cheque::findOrFail($request->vt_id);
		$chq->isVerify = $request->isVerify;
		$chq->save();

		return $csh;
	}
	public function cheque_table(Request $request)
	{
		$chq = DB::table('cheques')
		->join('billing_invoice_headers', 'cheques.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->join('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->select('cheques.id','companyName','bankName', 'amount', 'cheques.bi_head_id')
		->where('isVerify', '=', 0)
		->where('billing_invoice_headers.status', '=', 'U')
		->get();

		return Datatables::of($chq)
		->addColumn('action', function ($ch) {
			return
			'<button value = "'. $ch->id .'" style="margin-right:10px; width:100;" class = "btn btn-primary chq_con" data-toggle="modal" data-target="#confirmModal">Confirm</button>';
		})
		->make(true);
	}
	public function confirm_cheque(Request $request)
	{
		$chq = Cheque::findOrFail($request->vt_id);
		$chq->isVerify = $request->isVerify;
		$chq->save();

		return $csh;
	}
}
