<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditTrailController extends Controller
{

    public function index()
    {
        $audit = \DB::table('audit_trails')
        ->select(
            'name',
            'description',
            'audit_trails.created_at'
        )
        ->join('users as A', 'audit_trails.user_id', '=', 'A.id')
        ->get();
        return view('admin.audit.audit', compact(['audit']));
    }


    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
