<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShipmentReportsController extends Controller
{
    public function index()
    {
    	return view('reports/shipment_index');
    }
}
