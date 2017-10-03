<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use DB;
use App\ConsigneeServiceOrderHeader;
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
		->get();

		return view('order.order_view', compact(['so_head']));
	}
	

	public function store(Request $request)
	{
		$new_so_head = new ConsigneeServiceOrderHeader;
		$new_so_head->consignees_id = $request->consignees_id;
		$new_so_head->employees_id = $request->processedBy;
		$new_so_head->save();
		return $new_so_head;
	
	}
	
}