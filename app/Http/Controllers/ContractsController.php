<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\ContainerType;
use App\Area;
use App\ContractHeader;
use App\ContractDetail;
use App\ContractAmendment;
use App\ContractTemplate;
use Response;
use App;
use PDF;

class ContractsController extends Controller
{

    public function index()
    {
        return view('/trucking.contract_index');
    }
    public function manage_contract(Request $request){
        try
        {
            $contract = DB::table('contract_headers')
            ->select('contract_headers.id', 'dateEffective', 'dateExpiration', 'specificDetails', 'consignees_id', 'companyName' , DB::raw('CONCAT(firstName, " ", lastName) AS name'))
            ->join('consignees AS B', 'consignees_id', '=', 'B.id')
            ->where('contract_headers.id', '=', $request->contract_id)
            ->get();

            $contract_details = DB::table('contract_details')
            ->select('A.description AS from', 'B.description AS to', 'amount')
            ->join('areas AS A', 'areas_id_from', '=', 'A.id')
            ->join('areas AS B', 'areas_id_to', '=', 'B.id')
            ->where('contract_headers_id', '=', $request->contract_id)
            ->get();
            return view('/trucking.contract_view', compact(['contract', 'contract_details']));

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
    public function create_contract(Request $request){
        $file = fopen('contract.txt', 'r');
        $fileContent = fread($file, filesize('contract.txt'));
        fclose($file);

        $newContent = str_replace("!-_Date_-!", "Date: ", $fileContent);
        $newContent = str_replace("!-_Consignee_-!", "Consignee: " .$request->consigneeName, $newContent);
        $newContent = str_replace("!-_Date_Effective_-!", "Date Effective : " . $request->dateEffective, $newContent);
        $newContent = str_replace("!-_Date_Expiration_-!", "Date Expiration : " . $request->dateExpiration, $newContent);
        $newContent .= "\n From \t\t To \t\t Amount\n";
        for($i = 0; $i < count($request->areas_from); $i++)
        {
            $newContent .= $request->from_id_descrp[$i] . "\t\t" . $request->to_id_descrp[$i] . "\t\t" . $request->amount[$i] . "\n";
        }

        $new_contract = new ContractHeader;
        $new_contract->dateEffective = date_create($request->dateEffective);
        $new_contract->dateExpiration = date_create($request->dateExpiration);
        $new_contract->consignees_id = $request->consigneeID;
        $new_contract->specificDetails = $request->specificDetails;
        $new_contract->save();


        $new_contract =  ContractHeader::all()->last();

        for($i = 0; $i < count($request->areas_from); $i++){
            $contract_detail = new ContractDetail;
            $contract_detail->areas_id_from = $request->areas_from[$i];
            $contract_detail->areas_id_to = $request->areas_to[$i];

            $contract_detail->amount = $request->amount[$i];
            $contract_detail->currentRate = 1;
            $contract_detail->contract_headers_id = $new_contract->id;
            $contract_detail->save();
        }
        Storage::disk('local')->put($request->consigneeID ."_". str_replace(" ", "_", $request->consigneeName).".txt", $newContent);

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

            $contract_details = DB::table('contract_details')
            ->select('A.description AS from', 'B.description AS to', 'amount')
            ->join('areas AS A', 'areas_id_from', '=', 'A.id')
            ->join('areas AS B', 'areas_id_to', '=', 'B.id')
            ->where('contract_headers_id', '=', $request->contract_id)
            ->get();

            $pdf = PDF::loadView('pdf_layouts.contract_pdf', compact(['contract', 'contract_details']));
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

        $contract_details = DB::table('contract_details')
        ->select('A.description AS from', 'B.description AS to', 'amount')
        ->join('areas AS A', 'areas_id_from', '=', 'A.id')
        ->join('areas AS B', 'areas_id_to', '=', 'B.id')
        ->where('contract_headers_id', '=', $request->contract_id)
        ->get();

        $pdf = PDF::loadView('pdf_layouts.agreement_pdf', compact(['contract', 'contract_details']));
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
        $contract = DB::table('contract_headers')
        ->select('contract_headers.id', 'dateEffective', 'dateExpiration', 'specificDetails', 'consignees_id', 'companyName' , DB::raw('CONCAT(firstName, " ", lastName) AS name'))
        ->join('consignees AS B', 'consignees_id', '=', 'B.id')
        ->where('contract_headers.id', '=', $request->contract_id)
        ->get();
      

        $terms = explode('<br /><br />', $contract[0]->specificDetails);
        array_pop($terms);


        return view('/trucking.contract_draft', compact(['contract', 'terms']));

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
    ->select('contract_headers.id', 'dateEffective', 'dateExpiration', 'specificDetails', 'consignees_id', 'companyName' , DB::raw('CONCAT(firstName, " ", lastName) AS name'))
    ->join('consignees AS B', 'consignees_id', '=', 'B.id')
    ->where('contract_headers.id', '=', $request->contract_id)
    ->get();

    $contract_details = DB::table('contract_details')
    ->select('A.description AS from', 'B.description AS to', 'amount', 'contract_details.id', 'A.id as area_from_id', 'B.id as area_to_id')
    ->join('areas AS A', 'areas_id_from', '=', 'A.id')
    ->join('areas AS B', 'areas_id_to', '=', 'B.id')
    ->where('contract_headers_id', '=', $request->contract_id)
    ->get();

    $areas = Area::all();

    $amendments = DB::table('contract_amendments')
    ->select('created_at', 'amendment')
    ->where('contract_headers_id', '=', $request->contract_id)
    ->orderBy('created_at', 'DESC')
    ->get();

    $terms = explode('<br /><br />', $contract[0]->specificDetails);
    array_pop($terms);


    return view('/trucking.contract_amend', compact(['contract', 'contract_details', 'areas', 'amendments', 'terms']));

}
catch(Exception $e){
    return redirect('/trucking/contracts');
}
}

public function update(Request $request, $id){

    switch ($request->update_type) {
        case '1':
        $contract = ContractHeader::findOrFail($request->contract_id);
        $contract->dateEffective = $request->dateEffective;
        $contract->dateExpiration = $request->dateExpiration;

        $contract->save();

        return $contract;

        break;

        case '2':
        $contract_detail = ContractDetail::findOrFail($request->contract_detail_id);
        $contract_detail->areas_id_from = $request->areas_id_from;
        $contract_detail->areas_id_to = $request->areas_id_to;
        $contract_detail->amount = $request->amount;

        $contract_detail->save();

        return $contract_detail;

        break;

        case '3':
        $contract = ContractHeader::findOrFail($request->contract_id);
        $contract->specificDetails = $request->specificDetails;

        $contract->save();

        return $contract;

        break;

        default:

        break;
    }
}
public function store_contract_rates(Request $request)
{

    $contract_detail = new ContractDetail;
    $contract_detail->areas_id_from = $request->areas_id_from;
    $contract_detail->areas_id_to = $request->areas_id_to;
    $contract_detail->amount = $request->amount;
    $contract_detail->contract_headers_id = $request->contract_id;

    $contract_detail->save();

    $contract_amendment = new ContractAmendment;
    $contract_amendment->amendment = "Added new rate: " . $request->from_descrp . " to " . $request->to_descrp . ": Php " 
    . $contract_detail->amount;
    $contract_amendment->contract_headers_id = $request->contract_id;

    $contract_amendment->save();

    return Response::make(array($contract_detail, $contract_amendment));
}
}
