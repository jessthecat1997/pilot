<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class QuotationsController extends Controller
{

    public function index()
    {
        
        return view('quotations.quotation_index');
    }

    
    public function create()
    {
        $consignees = \App\Consignee::all();

        $provinces = \App\LocationProvince::all();

        $terms = \App\QuotationTerm::all()->last();
        
        $term_array = explode("<br />", $terms->terms);
        array_pop($term_array);

        $locations = DB::table('locations')
        ->select('id', 'locations.name')
        ->where('deleted_at', '=', null)
        ->get();

        return view('quotations.quotation_create', compact(['term_array', 'locations', 'provinces', 'consignees']));
    }


    public function store(Request $request)
    {
        $new_quotation = new \App\QuotationHeader;
        $new_quotation->consignees_id = $request->consignees_id;
        $new_quotation->specificDetails = $request->specificDetails;
        $new_quotation->save();


        $new_quotation =  \App\QuotationHeader::all()->last();

        for($i = 0; $i < count($request->areas_from); $i++){
            $quotation_detail = new \App\QuotationDetail;
            $quotation_detail->locations_id_from = $request->areas_from[$i];
            $quotation_detail->locations_id_to = $request->areas_to[$i];

            $quotation_detail->amount = $request->amount[$i];
            $quotation_detail->quot_header_id = $new_quotation->id;
            $quotation_detail->save();
        }
       
        return $new_quotation;
    }

    
    public function show($id)
    {
        $quotation = DB::table('quotation_headers')
            ->select('quotation_headers.id', 'specificDetails', 'consignees_id', 'companyName' , DB::raw('CONCAT(firstName, " ", lastName) AS name'))
            ->join('consignees AS B', 'consignees_id', '=', 'B.id')
            ->where('quotation_headers.id', '=', $id)
            ->get();
           

            $quotation_details = DB::table('quotation_details')
            ->select('A.name AS from', 'B.name AS to', 'amount')
            ->join('locations AS A', 'locations_id_from', '=', 'A.id')
            ->join('locations AS B', 'locations_id_to', '=', 'B.id')
            ->where('quot_header_id', '=', $id)
            ->get();

        return view('quotations.quotation_view', compact(['quotation', 'quotation_details']));
    }

    public function print(Request $request){
        try
        {
            $quotation = DB::table('quotation_headers')
            ->select('specificDetails', 'companyName', DB::raw('CONCAT(firstName, " ", lastName) as name'), 'quotation_headers.created_at')
            ->join('consignees', 'consignees_id', '=', 'consignees.id')
            ->where('quotation_headers.id', '=', $request->id)
            ->get();

            $quotation_details = DB::table('quotation_details')
            ->select('A.name AS from', 'B.name AS to', 'amount')
            ->join('locations AS A', 'locations_id_from', '=', 'A.id')
            ->join('locations AS B', 'locations_id_to', '=', 'B.id')
            ->where('quot_header_id', '=', $request->id)
            ->get();

            $pdf = PDF::loadView('pdf_layouts.quotation_pdf', compact(['quotation', 'quotation_details']));
            return $pdf->stream();
        }
        catch(Exception $e){
            return redirect('/trucking/quotations');
        }
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
        $quotation = \App\QuotationHeader::findOrFail($id);
        $quotation->delete();
    }
}
