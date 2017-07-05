<?php

namespace App\Http\Controllers;

use App\PaymentMode;
use App\Payment;
use App\Http\Requests\StorePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
	public function index()
	{
		$payMode = PaymentMode::all();
		return view('payment/payment_index', compact(['payMode']));
	}
	public function store(StorePayment $request)
	{
		$new_payment = new Payment;

		$new_payment->amount = $request->amount;
		$new_payment->so_head_id = $request->so_head_id;
		$new_payment->payment_mode_id = $request->payment_mode_id;
		$new_payment->save();
	}
	public function getTotalAmt(Request $request)
	{
		$totbillamt = DB::table('billing_invoice_details')
		->select(DB::raw('SUM(amount)'))
		->where('bi_head_id', '=', $request->id)
		->get();
		return view::make('payment/payment_index')->with('totbillamt',$totbillamt);
	}
	public function getTotalRC()
	{
		
	}

	public function pdfview(Request $request)
	{
		$pay = Payment::all();
		return view('pdfview', compact(['pay']));
		$pays = DB::table("payments")
		->leftJoin('consignee_service_order_headers','payments.so_head_id', '=', 'consignee_service_order_headers.id')
		->leftJoin('consignees','consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->select('companyName', 'amount', 'payments.created_at')
		->get();
		view()->share('payments',$pays);

		if($request->has('download')){
			$pdf = PDF::loadView('pdfview');
			return $pdf->download('pdfview.pdf');
		}

		return view('pdfview');
	}
}
