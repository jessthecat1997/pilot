<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class QuotationsController extends Controller
{

    public function index()
    {
        $quotations = DB::table('quotation_headers')
        ->select(DB::raw('CONCAT(firstName, " ", lastName) as name'), 'quotation_headers.id', 'quotation_headers.created_at', 'contract_headers.id as con_head')
        ->join('consignees', 'consignees_id', '=', 'consignees.id')
        ->leftjoin('contract_headers', 'quotation_headers.id', '=', 'quot_head_id')
        ->where('quotation_headers.deleted_at', '=', null)
        ->get();

        return view('quotations.quotation_index', compact(['quotations']));
    }

    
    public function create()
    {
        $volumes = \App\ContainerType::all();

        $consignees = \App\Consignee::all();

        $provinces = \App\LocationProvince::all();

        $terms = \App\QuotationTerm::all()->last();
        
        $term_array = explode("<br />", $terms->terms);
        array_pop($term_array);

        $locations = DB::table('locations')
        ->select('id', 'locations.name')
        ->where('deleted_at', '=', null)
        ->get();

        return view('quotations.quotation_create', compact(['term_array', 'locations', 'provinces', 'consignees', 'volumes']));
    }


    public function store(Request $request)
    {
        $new_quotation = new \App\QuotationHeader;
        $new_quotation->consignees_id = $request->consignees_id;
        $new_quotation->specificDetails = $request->specificDetails;
        $new_quotation->save();


        $new_quotation =  \App\QuotationHeader::all()->last();

        $data = json_decode($request->_data);
        foreach ($data as $location => $value)
        {
            $container = json_decode((string)json_encode($value));
            foreach ($container as $key => $container_detail)
            {
                foreach ($container_detail->details as $key => $container_detail_data){
                    $quotation_detail = new \App\QuotationDetail;
                    $quotation_detail->locations_id_from = $container_detail->location[0]->location_from;;
                    $quotation_detail->locations_id_to = $container_detail->location[0]->location_to;;
                    $quotation_detail->container_volume = $container_detail_data->size;
                    $quotation_detail->amount = $container_detail->location[0]->amount;
                    $quotation_detail->quot_header_id = $new_quotation->id;
                    $quotation_detail->save();
                }

            }
        }

        $audit = new \App\AuditTrail;
        $audit->user_id = \Auth::user()->id;
        $audit->description = "Created new quotation id: " . $new_quotation->id;
        $audit->save();


        return $new_quotation;
    }

    public function get_quotation_location(Request $request)
    {
        $location = \DB::table('locations')
        ->join('location_cities as A', 'locations.cities_id', '=', 'A.id')
        ->join('location_provinces as B', 'A.provinces_id', '=', 'B.id')
        ->select('A.name as city', 'B.name as province', 'locations.address as location')
        ->where('locations.id', '=', $request->location_id)
        ->get();

        return $location;
    }

    public function get_quotation_rates(Request $request)
    {
        $location_from = \App\Location::withTrashed()->findOrFail($request->location_from);
        $location_to = \App\Location::withTrashed()->findOrFail($request->location_to);

        $standard_rate = \DB::table('standard_area_rates')
        ->select('amount', \DB::raw('DATE_FORMAT(created_at, "%M %d, %Y") as created_at'))
        ->where('areaTo', '=', $request->location_to)
        ->where('areaFrom', '=', $request->location_from)
        ->get();

        $delivery = \DB::table('delivery_receipt_headers')
        ->select('amount', \DB::raw('DATE_FORMAT(created_at, "%M %d, %Y") as new_created_at'), 'delivery_receipt_headers.id')
        ->where('locations_id_pick', '=', $request->location_from)
        ->where('locations_id_del', '=', $request->location_to)
        ->orderBy('created_at', 'DESC')
        ->get();

        $estimate = 0;
        foreach ($delivery as $key => $del) {
            $estimate += $del->amount;
        }
        if(count($delivery) > 0)
        {
            $estimate = ($estimate / count($delivery));   
        }


        return \Response::make(array($standard_rate, $delivery, $estimate));
    }

    public function show($id)
    {
        $quotation = DB::table('quotation_headers')
        ->select('quotation_headers.id', 'specificDetails', 'consignees_id', 'companyName' , DB::raw('CONCAT(firstName, " ", lastName) AS name'))
        ->join('consignees AS B', 'consignees_id', '=', 'B.id')
        ->where('quotation_headers.id', '=', $id)
        ->get();


        $quotation_details = DB::select('SELECT h.id, r.id, GROUP_CONCAT(t.name ORDER BY r.id) AS sizes, r.amount, lfrom.name as _from, lto.name as _to FROM quotation_headers h INNER JOIN quotation_details r ON h.id = r.quot_header_id INNER JOIN locations lfrom ON r.locations_id_from = lfrom.id JOIN locations lto ON r.locations_id_to = lto.id  LEFT JOIN container_types t ON t.id = r.container_volume WHERE h.id = ? GROUP BY lfrom.id, lto.id ', [$id]);

        return view('quotations.quotation_view', compact(['quotation', 'quotation_details']));
    }

    public function print(Request $request){
        try
        {
            $quotation = DB::table('quotation_headers')
            ->select('specificDetails', 'companyName', DB::raw('CONCAT(firstName, " ", lastName) as name'), 'quotation_headers.created_at', 'quotation_headers.id')
            ->join('consignees', 'consignees_id', '=', 'consignees.id')
            ->where('quotation_headers.id', '=', $request->id)
            ->get();

            $quotation_details = DB::select('SELECT h.id, r.id, GROUP_CONCAT(t.name ORDER BY r.id) AS sizes, r.amount, lfrom.name as _from, lto.name as _to FROM quotation_headers h INNER JOIN quotation_details r ON h.id = r.quot_header_id INNER JOIN locations lfrom ON r.locations_id_from = lfrom.id JOIN locations lto ON r.locations_id_to = lto.id  LEFT JOIN container_types t ON t.id = r.container_volume WHERE h.id = ? GROUP BY lfrom.id, lto.id ', [$request->id]);

            $audit = new \App\AuditTrail;
            $audit->user_id = \Auth::user()->id;
            $audit->description = "Printed quotation id: " . $quotation[0]->id;
            $audit->save();

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

        $audit = new \App\AuditTrail;
        $audit->user_id = \Auth::user()->id;
        $audit->description = "Deactivated quotation id: " . $quotation->id;
        $audit->save();
    }
}
