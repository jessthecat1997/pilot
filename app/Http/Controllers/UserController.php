<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Facades\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
	public function index()
	{
		return view('employee.user_index');
	}

	public function user_table(Request $request)
	{
		$user = DB::table('users')
		->join('employee_types', 'users.role_id', '=', 'employee_types.id')
		->select('users.name', 'email', 'employee_types.name')
		->get();

		return Datatables::of($user)
		->make(true);
	}
}
