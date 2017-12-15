<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
use PDF;

class BillingReportsController extends Controller
{
	public function index()
	{
		$current = \Carbon\Carbon::now('Asia/Hong_Kong');
		$now = \Carbon\Carbon::now('Asia/Hong_Kong')->format('m/d/Y');

		return view ('reports.billing_report', compact(['now', 'current']));
	}
	public function billing_pdf_report(Request $request)
	{
		if($request->blank == 1)
		{
			$pdf = PDF::loadView('reports.blank_pdf');
			$pdf->setPaper('A4', 'landscape');
			return $pdf->stream();
		}
		else
		{

			$utility = \App\UtilityType::all();	

			$status_filter = "";
			switch ($request->status) {
				case '0':
				$status_filter =  "bh.status IN ('P') ";
				break;
				case '1':
				$status_filter =  "bh.status IN ('U') ";
				break;
				default:
					# code...
				break;
			}

			$bills = DB::select('SELECT c.companyName,(CASE cg.bill_type when cg.bill_type = "R" then "Refundable Charges" when cg.bill_type = "E" then "Billing Invoice" end) as bill,  CONCAT("Php " ,FORMAT (bd.amount,2)) AS amount, (CASE bh.status when bh.status = "P" then "Unpaid" when bh.status = "U" then "Paid" end) as status, bh.date_billed FROM billing_invoice_headers bh INNER JOIN billing_invoice_details bd ON bh.id = bd.bi_head_id INNER JOIN charges as cg on bd.charge_id = cg.id INNER JOIN consignee_service_order_headers as ch on bh.so_head_id = ch.id INNER JOIN consignees as c on ch.consignees_id = c.id GROUP BY bh.id BETWEEN ? AND ? ', [\Carbon\Carbon::createFromFormat("Y-m-d", $request->date_from)->format("Y-m-d"), \Carbon\Carbon::createFromFormat("Y-m-d", $request->date_to)->format("Y-m-d")]);



			$pdf = PDF::loadView('reports.billing_pdf', compact(['bills', 'utility']));	
			$pdf->setPaper('A4', 'landscape');
			return $pdf->stream();
		}
	}
	public function pdfview(Request $request){
		$users = \DB::table("users")->get();
		view()->share('users',$users);

		if($request->has('download')) {
        	// pass view file
			$pdf = PDF::loadView('reports.pdfview');
            // download pdf
			return $pdf->download('userlist.pdf');
		}
		return view('reports.pdfview');
	}
}
