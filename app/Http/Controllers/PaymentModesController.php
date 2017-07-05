<?php

namespace App\Http\Controllers;

use App\PaymentMode;
use Illuminate\Http\Request;

class PaymentModesController extends Controller
{
     public function index()
    {
    	$payMode = PaymentMode::all();
		return view('payment/payment_index', compact(['payMode']));
    }
}
