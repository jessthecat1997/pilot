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

	public function show($id){
		
		$so_head = \DB::table('consignee_service_order_headers')
		->select('*')
		->join('consignees as A', 'consignee_service_order_headers.consignees_id', '=', 'A.id')
		->where('consignee_service_order_headers.id','=',$id)
		->get();

		
		return view('order.order_view', compact(['so_head']));

		/*


		$deliveries = DB::table('delivery_receipt_headers')
		->join('locations as A', 'locations_id_pick', '=', 'A.id')
		->join('locations as B', 'locations_id_del', '=', 'B.id')
		->join('location_cities as C', 'A.cities_id', '=', 'C.id')
		->join('location_cities as D', 'B.cities_id', '=', 'D.id')
		->select('delivery_receipt_headers.id', 'plateNumber', 'delivery_receipt_headers.created_at', 'status', 'A.name AS pickup_name', 'B.name as deliver_name', 'C.name AS pickup_city', 'D.name AS deliver_city', 'delivery_receipt_headers.deliveryDateTime', 'pickupDateTime')
		->where('delivery_receipt_headers.deleted_at', '=', null)
		->where('tr_so_id','=', $request->trucking_id)
		->get();



		*/



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
	
}