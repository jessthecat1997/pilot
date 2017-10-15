<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use DB;
use App\ConsigneeServiceOrderHeader;
use App\ConsigneeServiceOrderDetail;
use App\TruckingServiceOrder;
class OrdersController extends Controller
{
	public function index()
	{
		$orders = DB::select("SELECT s.id as id, CONCAT( c.firstName, ' ', c.middleName, ' ', c.lastName ) AS consignee, c.companyName, s.created_at, CONCAT(employees.firstName, ' ', employees.lastName ) AS employee FROM consignee_service_order_headers s JOIN consignees c ON s.consignees_id = c.id JOIN employees ON s.employees_id = employees.id");

		$employees = Employee::all();

		$consignees = \App\Consignee::all();

		return view('order.order_index', compact(['orders','employees', 'consignees']));
	}
	public function setConsigneeID(){

		$so_head = \DB::table('consignee_service_order_headers')
		->select('*')
		->join('consignees as A', 'consignee_service_order_headers.consignees_id', '=', 'A.id')
		->where('consignee_service_order_headers.id','=',$id)
		->get();

		session(['consignees_id' => '{{$so_head[0]->consignees_id}}' ]);
	}
	
	public function show(Request $request, $id){
		$reqs = \App\Requirement::all();
		
		$so_head = \DB::table('consignee_service_order_headers')
		->select(
			'consignee_service_order_headers.id',
			'A.firstName',
			'A.middleName',
			'A.lastName',
			'A.companyName',
			'A.b_address',
			'A.b_city',
			'A.b_st_prov',
			'consignees_id'
		)
		->join('consignees as A', 'consignee_service_order_headers.consignees_id', '=', 'A.id')
		->where('consignee_service_order_headers.id','=',$id)
		->get();

		$details = \DB::table('consignee_service_order_details')
		->where('so_headers_id', '=', $id)
		->get();

		$billings = \DB::table('billing_invoice_details')
		->select(
			'billing_invoice_details.amount',
			'billing_invoice_details.description',
			'A.name'
		)
		->join('charges as A', 'billing_invoice_details.charge_id', '=', 'A.id')
		->join('billing_invoice_headers as B', 'billing_invoice_details.bi_head_id', '=', 'B.id')
		->where('A.bill_type', '=', 'R')
		->where('so_head_id', '=', $so_head[0]->id)
		->get();
	
		$expenses = \DB::table('billing_invoice_details')
		->select(
			'billing_invoice_details.amount',
			'billing_invoice_details.description',
			'A.name'
		)
		->join('charges as A', 'billing_invoice_details.charge_id', '=', 'A.id')
		->join('billing_invoice_headers as B', 'billing_invoice_details.bi_head_id', '=', 'B.id')
		->where('A.bill_type', '=', 'E')
		->where('so_head_id', '=', $so_head[0]->id)
		->get();		
		
		$brokerages = null;  $truckings = null;
		for($i = 0; $i < count($details); $i++)
		{
			if($details[$i]->service_order_types_id == 1)
			{
				$brokerages =  \DB::table('brokerage_service_orders')
				->select('*')
				->where('consigneeSODetails_id', '=', $details[$i]->id)
				->get();

			}
			else
			{
				$truckings = \DB::table('trucking_service_orders')
				->select('*')
				->where('so_details_id', '=', $details[$i]->id)
				->get();

				
			}
		}
		return view('order.order_view', compact(['so_head', 'truckings', 'brokerages','deliveries', 'reqs', 'billings' ,'expenses']));
		
	}

	public function create_so_detail (Request $request) 
	{
		switch ($request->sot_type) {

			case '1':

			$new_so_detail = new ConsigneeServiceOrderDetail;
			$new_so_detail->so_headers_id = $request->so_headers_id;
			$new_so_detail->service_order_types_id = 1;
			$new_so_detail->save();
			break;

			case '2':

			$new_so_detail = new ConsigneeServiceOrderDetail;
			$new_so_detail->so_headers_id = $request->so_headers_id;
			$new_so_detail->service_order_types_id = 2;
			$new_so_detail->save();

			$new_trucking  = new TruckingServiceOrder;
			$new_trucking->status = "P";
			$new_trucking->bi_head_id_rev = null;
			$new_trucking->bi_head_id_exp = null;
			$new_trucking->so_details_id = $new_so_detail->id;
			$new_trucking->save();

			return $new_trucking;


			break;

			default:

			break;
		}
	}


	public function store(Request $request)
	{
		$new_so_head = new ConsigneeServiceOrderHeader;
		$new_so_head->consignees_id = $request->consignees_id;
		$new_so_head->employees_id = $request->processedBy;
		$new_so_head->save();
		return $new_so_head;

		switch ($request->sot_type) {

			case '1':

			$new_so_detail = new ConsigneeServiceOrderDetail;
			$new_so_detail->so_headers_id = $request->so_headers_id;
			$new_so_detail->service_order_types_id = 1;
			$new_so_detail->save();
			break;

			case '2':

			$new_so_detail = new ConsigneeServiceOrderDetail;
			$new_so_detail->so_headers_id = $request->so_headers_id;
			$new_so_detail->service_order_types_id = 2;
			$new_so_detail->save();



			break;

			default:

			break;
		}

	}

	public function create_so_billing_header(Request $request){

		
		switch ($request->sot_type) {

			case '1':

			$consignee_order = \DB::table('consignee_service_order_headers')
			->join('consignee_service_order_details AS A', 'A.so_headers_id', '=', 'consignee_service_order_headers.id')
			->join('brokerage_service_orders AS B', 'B.consigneeSODetails_id', '=', 'A.id')
			->select('consignee_service_order_headers.id')
			->where('B.id', '=', $request->br_so_id)
			->get();

			$vat = DB::select('SELECT rate FROM vat_rates where currentRate = 1');
			$billing_header = new \App\BillingInvoiceHeader;
			$billing_header->so_head_id = $consignee_order[0]->id;
			$billing_header->isRevenue = $request->isRevenue;
			$billing_header->vatRate = $vat[0]->rate;
			$billing_header->status = 'U';
			$billing_header->date_billed = \Carbon\Carbon::now();
			$billing_header->override_date = null;
			$billing_header->due_date = null;
			$billing_header->save();


			$consignee_header = \App\BrokerageServiceOrder::findOrFail($request->br_so_id);
			switch ($request->isRevenue) {
				case 0:
				$consignee_header->bi_head_id_exp = $billing_header->id;
				break;
				case 1:
				$consignee_header->bi_head_id_rev = $billing_header->id;
				break;
				default:
              # code...
				break;
			}
			$consignee_header->save();
			return $consignee_header;

			break;

			case '2':

			$consignee_order = \DB::table('consignee_service_order_headers')
			->join('consignee_service_order_details AS A', 'A.so_headers_id', '=', 'consignee_service_order_headers.id')
			->join('trucking_service_orders AS B', 'B.so_details_id', '=', 'A.id')
			->select('consignee_service_order_headers.id')
			->where('B.id', '=', $request->tr_so_id)
			->get();
			$vat = DB::select('SELECT rate FROM vat_rates where currentRate = 1');

			$billing_header = new \App\BillingInvoiceHeader;
			$billing_header->so_head_id = $consignee_order[0]->id;
			$billing_header->isRevenue = $request->isRevenue;
			$billing_header->vatRate = $vat[0]->rate;
			$billing_header->status = 'U';
			$billing_header->date_billed = \Carbon\Carbon::now();
			$billing_header->override_date = null;
			$billing_header->due_date = null;
			$billing_header->save();

			$consignee_header = \App\TruckingServiceOrder::findOrFail($request->tr_so_id);
			switch ($request->isRevenue) {
				case 0:
				$consignee_header->bi_head_id_exp = $billing_header->id;
				break;

				case 1:
				$consignee_header->bi_head_id_rev = $billing_header->id;
				break;

				default:
                # code...
				break;
			}
			$consignee_header->save();

			return $consignee_header;

			break;


			default:

			break;
		}
	}


	public function new_attachment(Request $request)
	{
		$attachment = new ServiceOrderAttachment;

		$attachment->so_head_id = $request->so_head_id;
		$attachment->req_type_id = $request->req_type_id;
		$attachment->description = $request->description;
		

		if($request->file_path != null){
			$input = $request->all();
			$input['image'] = time().'.' .$request->file_path->getClientOriginalExtension();
			$attachment->file_path = "attach." . $request->file_path->getClientOriginalExtension();
			$request->file_path->move(public_path('attach'), $input['image']);
		}
		
		$attachment->save();

		return $attachment;
	}

}