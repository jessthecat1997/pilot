<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\ContainerType;
use App\Area;
use App\ContractHeader;
use App\ContractAmendment;
use App\ContractTemplate;
use Response;
use App;
use PDF;

class ContractsController extends Controller
{

    public function index()
    {
        $contract_headers = DB::table('contract_headers')
        ->join('consignees', 'consignees_id', '=', 'consignees.id')
        ->select('contract_headers.id', 'dateEffective', 'isFinalize', 'dateExpiration', 'companyName', 'contract_headers.created_at')
        ->get();

        return view('/trucking.contract_index', compact(['contract_headers']));
    }
    public function manage_contract(Request $request){
        try
        {
            $contract = DB::table('contract_headers')
            ->select('contract_headers.id', 'dateEffective', 'dateExpiration', 'specificDetails', 'consignees_id', 'companyName' , DB::raw('CONCAT(firstName, " ", lastName) AS name'), 'quot_head_id')
            ->join('consignees AS B', 'consignees_id', '=', 'B.id')
            ->where('contract_headers.id', '=', $request->contract_id)
            ->get();
            if($contract[0]->quot_head_id != null)
            {
                $quotation = DB::table('quotation_headers')
                ->select('quotation_headers.id', 'specificDetails', 'consignees_id', 'companyName' , DB::raw('CONCAT(firstName, " ", lastName) AS name'))
                ->join('consignees AS B', 'consignees_id', '=', 'B.id')
                ->where('quotation_headers.id', '=', $contract[0]->quot_head_id)
                ->get();


                $quotation_details = DB::select('SELECT h.id, r.id, GROUP_CONCAT(t.name ORDER BY r.id) AS sizes, r.amount, lfrom.name as _from, lto.name as _to FROM quotation_headers h INNER JOIN quotation_details r ON h.id = r.quot_header_id INNER JOIN locations lfrom ON r.locations_id_from = lfrom.id JOIN locations lto ON r.locations_id_to = lto.id  LEFT JOIN container_types t ON t.id = r.container_volume WHERE h.id = ? GROUP BY lfrom.id, lto.id ', [$contract[0]->quot_head_id]);
            }
            
            return view('/trucking.contract_view', compact(['contract', 'quotation', 'quotation_details']));

        }
        catch(Exception $e){
            return redirect('/trucking/contracts');
        }
    }

    public function create()
    {
        $consignees = \App\Consignee::all();

        $provinces = \App\LocationProvince::all();

        $desc_array = [];
        $description = ContractTemplate::all()->last();
        if($description == null){

        }
        else{
            $desc_array = explode("<br /><br />", $description->description);
            array_pop($desc_array);
        }


        return view('trucking.contract_create', compact(['desc_array', 'consignees', 'provinces']));
    }

    public function get_quotations(Request $request)
    {
        $quotations = \DB::table('quotation_headers')
        ->select(\DB::raw('DATE_FORMAT(created_at, "%M %d, %Y") as new_created_at'), 'quotation_headers.id')
        ->where('consignees_id', '=', $request->consignee_id)
        ->orderBy('quotation_headers.id', 'DESC')
        ->get();
        return $quotations;
    }
    public function create_contract(Request $request){

        $new_contract = new ContractHeader;
        $new_contract->dateEffective = date_create($request->dateEffective);
        $new_contract->dateExpiration = date_create($request->dateExpiration);
        $new_contract->consignees_id = $request->consigneeID;
        $new_contract->specificDetails = $request->specificDetails;
        $new_contract->isFinalize = $request->isFinalize;;
        $new_contract->quot_head_id = $request->quot_head_id;
        $new_contract->save();


        $new_contract =  ContractHeader::all()->last();

        return $new_contract->id;
    }

    public function contract_pdf(Request $request)
    {
        try
        {
            $contract = DB::table('contract_headers')
            ->select('dateEffective', 'dateExpiration', 'specificDetails', 'companyName', DB::raw('CONCAT(firstName, " ", lastName) as name'), 'contract_headers.created_at')
            ->join('consignees', 'consignees_id', '=', 'consignees.id')
            ->where('contract_headers.id', '=', $request->contract_id)
            ->get();

            $pdf = PDF::loadView('pdf_layouts.contract_pdf', compact(['contract']));
            return $pdf->stream();
        }
        catch(Exception $e){
            return redirect('/trucking/contracts');
        }
    }

    public function agreement_pdf(Request $request)
    {
        try
        {
            $contract = DB::table('contract_headers')
            ->select('dateEffective', 'dateExpiration', 'specificDetails', 'companyName', DB::raw('CONCAT(firstName, " ", lastName) as name'), 'consignees.address', 'contract_headers.created_at')
            ->join('consignees', 'consignees_id', '=', 'consignees.id')
            ->where('contract_headers.id', '=', $request->contract_id)
            ->get();


            $pdf = PDF::loadView('pdf_layouts.agreement_pdf', compact(['contract']));
            return $pdf->stream();
        }
        catch(Exception $e){
            return redirect('/trucking/contracts');
        }
    }

    public function draft_contract(Request $request)
    {
        try
        {
            $consignees = \App\Consignee::all();
            $provinces = \App\LocationProvince::all();

            $contract = DB::table('contract_headers')
            ->select('contract_headers.id', 'dateEffective', 'dateExpiration', 'specificDetails','isFinalize', 'consignees_id', 'companyName' , DB::raw('CONCAT(firstName, " ", lastName) AS name'), 'quot_head_id')
            ->join('consignees AS B', 'consignees_id', '=', 'B.id')
            ->where('contract_headers.id', '=', $request->contract_id)
            ->get();

            $desc_array = explode('<br /><br />', $contract[0]->specificDetails);
            array_pop($desc_array);

            $quotations = DB::table('quotation_headers')
            ->where('consignees_id', '=', $contract[0]->consignees_id)
            ->get();

            return view('/trucking.contract_draft', compact(['contract','desc_array','consignees','provinces', 'quotations']));

        }
        catch(Exception $e){
            return redirect('/trucking/contracts');
        }

    }

    public function amend_contract(Request $request)
    {
        try
        {
            $contract = DB::table('contract_headers')
            ->select('contract_headers.id', 'dateEffective', 'dateExpiration', 'specificDetails', 'consignees_id', 'companyName' , DB::raw('CONCAT(firstName, " ", lastName) AS name'), 'quot_head_id')
            ->join('consignees AS B', 'consignees_id', '=', 'B.id')
            ->where('contract_headers.id', '=', $request->contract_id)
            ->get();

            $amendments = DB::table('contract_amendments')
            ->select('created_at', 'amendment')
            ->where('contract_headers_id', '=', $request->contract_id)
            ->orderBy('created_at', 'DESC')
            ->get();

            $quotations = DB::table('quotation_headers')
            ->where('consignees_id', '=', $contract[0]->consignees_id)
            ->get();

            $terms = explode('<br /><br />', $contract[0]->specificDetails);
            array_pop($terms);


            return view('/trucking.contract_amend', compact(['contract', 'areas', 'amendments', 'terms', 'quotations']));

        }
        catch(Exception $e){
            return redirect('/trucking/contracts');
        }
    }

    public function update(Request $request, $id)
    {

        $newdateFrom = \Carbon\Carbon::parse($request->dateEffective)->toFormattedDateString();
        $newdateTo = \Carbon\Carbon::parse($request->dateExpiration)->toFormattedDateString();

        $dateFrom = \Carbon\Carbon::parse($request->dateEffectivep)->toFormattedDateString();
        $dateTo = \Carbon\Carbon::parse($request->dateExpirationp)->toFormattedDateString();

        switch ($request->update_type) {
            case '1':
            $contract = ContractHeader::findOrFail($request->contract_id);
            $contract->dateEffective = $request->dateEffective;
            $contract->dateExpiration = $request->dateExpiration;

            $contract->save();


            $new_amend = new ContractAmendment;
            $new_amend->amendment = "Date changed from : { " . $dateFrom . " - " . $dateTo . " } \n to"
            . " { " . $newdateFrom . " - " . $newdateTo . " }";
            $new_amend->contract_headers_id = $request->contract_id;
            $new_amend->save();

            return $contract;

            break;

            case '2':

            break;

            case '3':
            $contract = ContractHeader::findOrFail($request->contract_id);
            $contract->specificDetails = $request->specificDetails;

            $contract->save();

            $new_amend = new ContractAmendment;
            $new_amend->amendment = "Updated terms and conditions";
            $new_amend->contract_headers_id = $request->contract_id;
            $new_amend->save();

            return $contract;

            break;

            case '4':
            $contract = ContractHeader::findOrFail($request->contract_id);
            $contract->dateEffective = $request->dateEffective;
            $contract->dateExpiration = $request->dateExpiration;
            $contract->specificDetails = $request->specificDetails;
            $contract->isFinalize = $request->isFinalize;
            $contract->quot_head_id = $request->quot_head_id;
            $contract->save();

            return $contract;

            break;

            case '5':
            $contract = ContractHeader::findOrFail($request->contract_id);
            $contract->quot_head_id = $request->quot_head_id;
            $contract->save();

            $new_amend = new ContractAmendment;
            $new_amend->amendment = "Changed quotation";
            $new_amend->contract_headers_id = $request->contract_id;
            $new_amend->save();

            return $contract;

            default:

            break;
        }
    }
    public function store_contract_rates(Request $request)
    {

    }
}
