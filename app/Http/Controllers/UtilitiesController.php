<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilitiesController extends Controller
{
    public function index()
	{
		return view('admin/utilities/home_utilities');
	}
}
