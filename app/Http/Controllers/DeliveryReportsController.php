<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryReportsController extends Controller
{
    public function index()
    {
		return view ('reports.delivery_report');	
    }
}
