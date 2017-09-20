<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
	public function index()
	{
		$orders = \App\ConsigneeServiceOrderHeader::all();
		return view('order/order_index', compact(['orders']));
	}
}