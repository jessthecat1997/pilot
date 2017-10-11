<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

class BillingReportsController extends Controller
{
	public function index()
	{
		return view('reports/billing_reports');
	}
	public function bill_table(Request $request)
	{
		$bills = DB::select("SELECT c.companyName, GROUP_CONCAT(CONCAT(cg.name) SEPARATOR '\n') AS part, GROUP_CONCAT(CONCAT('Php ' ,FORMAT (bd.amount,2)) SEPARATOR '\n') AS amount, bh.date_billed FROM billing_invoice_headers bh INNER JOIN billing_invoice_details bd ON bh.id = bd.bi_head_id INNER JOIN charges as cg on bd.charge_id = cg.id INNER JOIN consignee_service_order_headers as ch on bh.so_head_id = ch.id INNER JOIN consignees as c on ch.consignees_id = c.id WHERE bh.deleted_at IS NULL AND bh.status = 'U' GROUP BY bh.id");
		return Datatables::of($bills)
		->make(true);
	}
}
