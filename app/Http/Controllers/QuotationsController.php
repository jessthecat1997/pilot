<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class QuotationsController extends Controller
{

    public function index()
    {
        return view('quotations.quotation_index');
    }

    
    public function create()
    {
        $terms = \App\QuotationTerm::all()->last();
        
        $term_array = explode("<br/>", $terms->terms);
        array_pop($term_array);

        $locations = DB::table('locations')
        ->select('id', 'locations.name')
        ->where('deleted_at', '=', null)
        ->get();

        return view('quotations.quotation_create', compact(['term_array', 'locations']));
    }


    public function store(Request $request)
    {
        $quotation = \App\QuotationHeader::create($request->all());
        return $quotation;
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
