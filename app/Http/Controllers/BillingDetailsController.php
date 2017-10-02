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
		$billing_header =  BillingInvoiceHeader::all('id')->last();

		$vat = DB::table('vat_rates')
		->select(DB::raw('CONCAT(TRUNCATE(rate,2)) as rates'))
		->get();

		return view('billing/billing_select', compact(['bills', 'so_head_id', 'vat', 'billing_header']));
	}
	public function get_detail(Request $request){
		$charge = DB::table('charges')
		->select('amount')
		->where('charges.id', '=', $request->id)
		->get();

		return $charge;
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

	public function postBrokeragePayable(Request $request){
		$new_bill_detail = new \App\BillingInvoiceDetails;
		$new_bill_detail->description = $request->description;
		$new_bill_detail->amount = $request->amount;
		$new_bill_detail->tax = 0;
		$new_bill_detail->charge_id = $request->charge_id;
		$new_bill_detail->bi_head_id = $request->bi_head_id;
		$new_bill_detail->save();

		if($request->isBrokerageFee == 1)
		{
			$new_order_billedrevenue = new \App\OrderBilledRevenues;
			$new_order_billedrevenue->order_brokerage_id = $request->declaration_id;
			$new_order_billedrevenue->bi_head_id = $new_bill_detail->id;
			$new_order_billedrevenue->save();
		}
		return $new_bill_detail;
	}

	public function postBrokerageRefundable(Request $request){
		$new_bill_detail = new \App\BillingInvoiceDetails;
		$new_bill_detail->description = $request->description;
		$new_bill_detail->amount = $request->amount;
		$new_bill_detail->tax = 0;
		$new_bill_detail->charge_id = $request->charge_id;
		$new_bill_detail->bi_head_id = $request->bi_head_id;
		$new_bill_detail->save();

		if($request->isBrokerageFee == 1)
		{
			$new_order_billedrevenue = new \App\OrderBilledRevenues;
			$new_order_billedrevenue->order_brokerage_id = $request->declaration_id;
			$new_order_billedrevenue->bi_head_id = $new_bill_detail->id;
			$new_order_billedrevenue->save();
		}
		return $new_bill_detail;
	}

	public function getBrokerageBillingDetails(Request $request){

		$id = $request->id;
		$billing_details = DB::select('SELECT br_so.id as br_so, bl_head.id as bl_head, bl_det.id as bl_det, charge.id as charge_id, charge.name, SUM(bl_det.amount) as amount, bl_det.description FROM brokerage_service_orders br_so INNER JOIN consignee_service_order_headers con_ord ON con_ord.id = br_so.consigneeSODetails_id INNER JOIN billing_invoice_headers bl_head ON bl_head.so_head_id = con_ord.id LEFT JOIN billing_invoice_details bl_det ON bl_head.id = bl_det.bi_head_id INNER JOIN charges charge ON charge.id = bl_det.charge_id WHERE br_so.id = '.$id.' AND bl_head.isRevenue = 1 GROUP BY charge.id');
		return Datatables::of($billing_details)
		->make(true);

	}

	public function getBrokerageRefundableDetails(Request $request){

		$id = $request->id;
		$billing_details = DB::select('SELECT br_so.id as br_so, bl_head.id as bl_head, bl_det.id as bl_det, charge.id as charge_id, charge.name, SUM(bl_det.amount) as amount, bl_det.description FROM brokerage_service_orders br_so INNER JOIN consignee_service_order_headers con_ord ON con_ord.id = br_so.consigneeSODetails_id INNER JOIN billing_invoice_headers bl_head ON bl_head.so_head_id = con_ord.id LEFT JOIN billing_invoice_details bl_det ON bl_head.id = bl_det.bi_head_id INNER JOIN charges charge ON charge.id = bl_det.charge_id WHERE br_so.id = '.$id.' AND bl_head.isRevenue = 0 GROUP BY charge.id');
		return Datatables::of($billing_details)
		->make(true);

	}



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
		->select('consignee_service_order_headers.id', 'companyName', 'service_order_types.name', DB::raw('CONCAT(b_address, ", ", b_city, ", ", b_st_prov) AS address'), 'isRevenue', 'status','due_date', 'isFinalize')
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
		->select('charges.name', 'billing_invoice_details.amount', 'billing_invoice_details.description')
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
		->select('charges.name', 'billing_invoice_details.amount', 'billing_invoice_details.description')
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
		->select('consignee_service_order_headers.id', 'companyName', 'service_order_types.name', DB::raw('CONCAT(b_address, ", ", b_city, ", ", b_st_prov) AS address'), 'isRevenue', 'status','due_date')
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
			C.companyName, t.isFinalize,
			CONCAT("Php ",(ROUND(((p.total * t.vatRate)/100), 2) + p.total)) as Total,
			coalesce((ROUND(((p.total * t.vatRate)/100), 2) + p.total), 0 ) as totall,
			coalesce(DATE_FORMAT(t.due_date, "%M %d, %Y"), "Not set") as due_date,
			t.status

			FROM billing_invoice_headers t LEFT JOIN
			(
			SELECT bi_head_id, SUM(amount) total
			FROM billing_invoice_details
			GROUP BY bi_head_id
			) p

			ON t.id = p.bi_head_id
			JOIN consignee_service_order_headers AS B on t.so_head_id = B.id
			JOIN consignees AS C on B.consignees_id = C.id
			WHERE t.isVoid = 0 AND p.total != 0.00;
			');

		return Datatables::of($bill_hists)
		->addColumn('action', function ($hist) {

			if($hist->isFinalize == 0)
			{
				return
				'<a href = "/billing/'. $hist->id .'/create" style="margin-right:10px; width:100;" class = "btn btn-md btn-info bill_inv"><i class="fa fa-eye"></i></a>';
			}
			else
			{
				return
				'<a href = "/billing/'. $hist->id .'/show_pdf" style="margin-right:10px; width:100;" class = "btn btn-md but bill_inv"><i class="fa fa-print"></i></a>';
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

	public function getBrokerageFees(Request $request)
	{
		$brokerage = DB::table('duties_and_taxes_headers')
		->select('duties_and_taxes_headers.id', 'id', 'brokerageFee')
		->where('statusType', '=', 'A')
		->where('brokerageServiceOrders_id', '=', $request->br_so_id)
		->get();

		return $brokerage;
	}

	public function getBrokerageCharges(Request $request)
	{
		$charges = DB::table('charges')
		->select('amount', 'id')
		->where('id', '=', $request->charge_id)
		->get();

		return $charges;
	}

	public function billing_history(Request $request)
	{
		$bill_history = DB::table('billing_invoice_headers')
		->select('id', 'isFinalize', 'due_date')
		->where([
			['billing_invoice_headers.so_head_id', '=', $request->id],
			['isVoid', '=', 0 ],
			['isFinalize', '=', 0]
			])
		->get();

		return Datatables::of($bill_history)
		->addColumn('action', function ($history) {
			return
			'<a href = "/billing/'. $history->id .'/create" style="margin-right:10px; width:100;" class = "btn btn-md btn-primary bill_inv"><i class="fa fa-plus"></i></a>'.
			'<button type="button" style="margin-right:10px; width:100;" class="btn btn-md btn-info updateBill" data-toggle="modal" data-target="#updateModal" value="'. $history->id .'"><i class="fa fa-edit"></i></button>'.
			'<button type="button" style="margin-right:10px; width:100;" class="btn btn-md btn-danger voidBill" data-toggle="modal" data-target="#voidModal" value="'. $history->id .'"><i class="fa fa-times"></i></button>';

		})
		->make(true);
	}
	public function finalize_bill(Request $request, $id)
	{
		$finalize = BillingInvoiceHeader::findOrFail($id);
		$finalize->isFinalize = $request->isFinalize;
		$finalize->save();

		return $finalize;
	}
	public function void_bill(Request $request)
	{
		$void = BillingInvoiceHeader::findOrFail($request->bi_head);
		$void->isVoid = $request->isVoid;
		$void->save();

		return $void;
	}
	public function postBilling_header(Request $request)
	{
		$billing_header = new BillingInvoiceHeader;
		$billing_header->so_head_id = $request->so_head_id;
		$billing_header->isRevenue = 1;
		$billing_header->isVatFree = 0;
		$billing_header->isVoid = 0;
		$billing_header->vatRate = $request->vatRate;
		$billing_header->status = $request->status;
		$billing_header->date_billed = $request->date_billed;
		$billing_header->override_date = $request->override_date;
		$billing_header->due_date = $request->due_date;
		$billing_header->save();
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
	public function update(Request $request, $id)
	{
		$csh = BillingInvoiceHeader::findOrFail($id);
		$csh->date_billed = $request->date_billed;
		$csh->due_date = $request->due_date;
		$csh->save();

		return $csh;
	}
	public function bill_pdf(Request $request, $id)
	{
		$bills = DB::table('consignee_service_order_headers')
		->join('consignee_service_order_details', 'consignee_service_order_headers.id', '=', 'consignee_service_order_details.so_headers_id')
		->join('consignees', 'consignee_service_order_headers.consignees_id','=','consignees.id')
		->join('service_order_types', 'consignee_service_order_details.service_order_types_id', '=', 'service_order_types.id')
		->join('billing_invoice_headers', 'consignee_service_order_headers.id', '=', 'billing_invoice_headers.so_head_id')
		->select('consignee_service_order_headers.id','companyName','service_order_types.name', DB::raw('CONCAT(b_address, ", ", b_city, ", ", b_st_prov) AS address'),'TIN', 'businessStyle', 'billing_invoice_headers.date_billed', 'isRevenue','due_date')
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

		$pdf = PDF::loadView('pdf_layouts.bill_invoice_pdf', compact(['rev_bill', 'bills', 'number', 'rev_total','rev_vat','exp_bill', 'exp_total', 'exp_total', 'exp_vat']));
		return $pdf->stream();
	}
	public function ref_pdf(Request $request, $id)
	{
		$pdf = PDF::loadView('pdf_layouts.refundable_charges_pdf');
		return $pdf->stream();
	}
}
