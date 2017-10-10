<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Facades\Datatables;
use App\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
	public function index()
	{
		$user = DB::table('users')
		->select('id','users.name', 'users.email')
		->get();
		$roles = DB::table('roles')
		->select('id','name')
		->get();
		return view('auth/roles', compact('user', 'roles'));
	}
	public function show(Request $request)
	{
		$user = DB::table('users')
		->select('id','users.name', 'users.email')
		->get();
		$roles = DB::table('roles')
		->select('id','name')
		->get();
		return view('auth/roles', compact('user', 'roles'));
	}
	public function store(Request $request)
	{
		$r = new RoleUser;
		$r->role_id = $request->role_id;
		$r->user_id = $request->user_id;
		$r->save();
	}

}
