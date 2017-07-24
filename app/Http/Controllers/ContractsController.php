<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\ContainerType;
use App\Area;
use App\ContractHeader;
use App\ContractDetail;
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
        $areas = Area::where('deleted_at', '=', null)->orderBy('description', 'asc')->get();
        $volumes = ContainerType::all();

        return view('/trucking.contract_create', compact(['areas', 'volumes']));
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
            ->select('dateEffective', 'dateExpiration', 'specificDetails', 'companyName', DB::raw('CONCAT(firstName, " ", lastName) as name'))
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
            ->select('dateEffective', 'dateExpiration', 'specificDetails', 'companyName', DB::raw('CONCAT(firstName, " ", lastName) as name'), 'consignees.address')
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
}
