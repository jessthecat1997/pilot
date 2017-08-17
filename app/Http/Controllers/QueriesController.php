<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QueriesController extends Controller
{
   
    public function index()
    {
        return view('queries.queries_index');
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
