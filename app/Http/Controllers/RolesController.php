<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Facades\Datatables;
use App\Role;
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
	}
	public function update(Request $request)
	{
		$r = Role::findOrFail($request->us_id);
		$r->role_id = $request->role_id;
		$r->save();
		return $r;
	}
	public function updateRole(Request $request)
	{
		$r = Role::findOrFail($request->us_id);
		$r->role_id = $request->role_id;
		$r->save();
		return $r;
	}

}
