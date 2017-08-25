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
	public function show(Request $request, $id)
	{
		$bills = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->select('consignee_service_order_headers.id', 'companyName', 'service_order_types.name', DB::raw('CONCAT(b_address, ", ", b_city, ", ", b_st_prov) AS address'))
		->where('consignee_service_order_headers.id', '=', $id)
		->get();

		$so_head_id = $id;

		$vat = DB::table('vat_rates')
		->select(DB::raw('CONCAT(TRUNCATE(rate,2)) as rates'))
		->get();

		return view('billing/billing_select', compact(['bills', 'so_head_id', 'vat']));
	}
	public function get_detail(Request $request){
		$charge = DB::table('charges')
		->select('amount')
		->where('charges.id', '=', $request->id)
		->get();

		return $charge;
	}
<<<<<<< HEAD

	public function postTruckingPayable(Request $request){
		$new_bill_detail = new \App\BillingInvoiceDetails;
		$new_bill_detail->description = $request->description;
		$new_bill_detail->amount = $request->amount;
		$new_bill_detail->tax = 0;
		$new_bill_detail->charge_id = $request->charge_id;
		$new_bill_detail->bi_head_id = $request->bi_head_id;
		$new_bill_detail->save();

		return $new_bill_detail;
	}

	public function postTruckingExpense(Request $request){
		$new_bill_detail = new \App\BillingInvoiceDetails;
		$new_bill_detail->description = $request->description;
		$new_bill_detail->amount = $request->amount;
		$new_bill_detail->tax = 0;
		$new_bill_detail->charge_id = $request->charge_id;
		$new_bill_detail->bi_head_id = $request->bi_head_id;
		$new_bill_detail->save();

		return $new_bill_detail;
	}

	public function getBillingDetails(Request $request){
		$billing_details = DB::table('billing_invoice_details')
		->select('charges.name', 'billing_invoice_details.description', 'billing_invoice_details.amount')
		->join('charges', 'charge_id', '=', 'charges.id')
		->where('bi_head_id', '=', $request->id)
		->get();
		return Datatables::of($billing_details)
		->make(true);
	}
=======
>>>>>>> master
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
	public function view_billing(Request $request, $id)
	{
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

		return view('billing/billing_view', compact(['vat', 'bills','bill_revs', 'bill_exps','so_head_id', 'rev_vat', 'rev_total', 'rev_bill','exp_vat', 'exp_total', 'exp_bill']));
	}
	public function billing_invoice(Request $request)
	{

		$bill_hists = DB::select('SELECT t.id, 
			C.companyName,
			(CASE t.isRevenue
			WHEN t.isRevenue = 1 THEN "Revenue"
			WHEN t.isRevenue = 0 THEN "Expense"
			END) as isRevenue,	
			CONCAT("Php ", p.total) as Total,
			DATE_FORMAT(t.due_date, "%M %d, %Y") as due_date,
			t.status


			FROM billing_invoice_headers t LEFT JOIN 
			(
			SELECT bi_head_id, SUM(amount) total
			FROM billing_invoice_details
			GROUP BY bi_head_id
			) p
			ON t.id = p.bi_head_id
			JOIN consignee_service_order_headers AS B on t.so_head_id = B.id
			JOIN consignees AS C on B.consignees_id = C.id');

		return Datatables::of($bill_hists)
		->addColumn('action', function ($hist) {
			return
			'<a href = "/billing/'. $hist->id .'/view" style="margin-right:10px; width:100;" class = "btn btn-md btn-info bill_inv"><i class="fa fa-eye"></i></a>'.
			'<a href = "/billing/'. $hist->id .'/show_pdf" style="margin-right:10px; width:100;" class = "btn btn-md but bill_inv"><i class="fa fa-print"></i></a>';
		})
		->addColumn('status', function ($hist) {
			switch ($hist->status) {
				case 'U':
					return 'Not paid';
					break;
				case 'P':
					return 'Paid';
					break;
				
				default:
					# code...
					break;
			}
		})
		->make(true);
	}

	public function getDeliveryFees(Request $request)
	{
		$deliveries = DB::table('delivery_receipt_headers')
		->select('amount', 'id')
		->where('tr_so_id', '=', $request->tr_so_id)
		->whereRaw('status IN ("C", "F")')
		->get();

		return $deliveries;
	}

	public function billing_history(Request $request)
	{
		$bill_history = DB::table('billing_invoice_headers')
		->select('id', 'isRevenue', 'due_date')
		->where('billing_invoice_headers.so_head_id', '=', $request->id)
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
		->where('billing_invoice_headers.id', '=', $id)
		->get();
		$number = $id;

		$rev_bill = DB::table('billing_invoice_details')
		->join('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('charges', 'billing_invoice_details.charge_id', '=', 'charges.id')
		->select('charges.name', 'billing_invoice_details.amount')
		->where([
			['billing_invoice_details.bi_head_id', '=', $id],
			['charges.bill_type', '=', 'R']
			])
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

		$pdf = PDF::loadView('pdf_layouts.bill_invoice_pdf', compact(['rev_bill', 'bills', 'number', 'rev_total','rev_vat']));
		return $pdf->stream();
	}

}
