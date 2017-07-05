<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReceiveType;
class BrokerageController extends Controller
{
    public function index()
    {
    	$rts = ReceiveType::all();
    	return view('brokerage/brokerage_service_order', compact(['rts']));
    }
}
