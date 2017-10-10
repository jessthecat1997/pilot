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
		return view('auth.roles', compact('user', 'roles'));
	}
	public function users_table(Request $request)
	{
		$users = DB::table('role_user')
		->join('users', 'role_user.user_id', '=', 'users.id')
		->join('roles', 'role_user.role_id', '=', 'roles.id')
		->select('role_user.id','users.name', 'users.email', 'roles.name')
		->get();
		return Datatables::of($users)
		->addColumn('action', function ($ch) {
			return
			'<button value = "'. $ch->id .'" style="margin-right:10px; width:100;" class = "btn btn-primary user_select">Select</button>';			
		})
		->make(true);
	}
	public function update(Request $request)
	{
		$r = Role::findOrFail($request->us_id);
		$r->role_id = $request->role_id;
		$r->save();
		return $r;
	}
}
