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
		->select('cheques.id','companyName','bankName', 'amount')
		->where('isVerify', '=', 0)
		->get();

		return Datatables::of($chq)
		->addColumn('action', function ($ch) {
			return
			'<button value = "'. $ch->id .'" style="margin-right:10px; width:100;" class = "btn btn-primary chq_con">Confirm</button>';
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
