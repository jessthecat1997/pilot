<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuotationsController extends Controller
{
   
    public function index()
    {
        return view('quotations.quotation_index');
    }

    
    public function create()
    {
        return view('quotations.quotation_create');
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
