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
		return view('order.order_view');
	}
}