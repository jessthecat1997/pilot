<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
	public function index()
	{
		$orders = \DB::table('consignee_service_order_headers')
		->select('*')
		->join('consignees', 'consignees_id', '=', 'consignees.id')
		->get();

		return view('order.order_index', compact(['orders']));
	}

	public function show($id){
		$so_head = \DB::table('consignee_service_order_headers')
		->select('*')
		->join('consignees as A', 'consignee_service_order_headers.consignees_id', '=', 'A.id')
		->get();

		return view('order.order_view', compact(['so_head']));
	}
	
}