<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\ConsigneeServiceOrderHeader;
use App\ConsigneeServiceOrderDetail;
use App\BrokerageServiceOrder;
use App\DutiesAndTaxesHeader;
use App\DutiesAndTaxesDetails;
use Illuminate\Support\Facades\DB;
use App\Employee;

class DutiesAndTaxesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      return view('brokerage.dutiesandtaxes_create');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {

      $employees = Employee::all();
      $brokerage_id = $request->brokerage_id;


      $brokerage_header = DB::table('brokerage_service_orders')
      ->select('brokerage_service_orders.id', 'companyName', 'consignees.id as consigneeid', 'locations.name as location', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight', 'location_id', 'firstName', 'middleName', 'lastName', 'statusType', 'freightType', 'withCO',  'bi_head_id_rev', 'bi_head_id_exp')
      ->join('consignee_service_order_details', 'consigneeSODetails_id', '=', 'consignee_service_order_details.id')
      ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
      ->join('consignees', 'consignees_id', '=', 'consignees.id')
      ->join('locations', 'location_id', '=', 'locations.id')
      ->where('brokerage_service_orders.id','=', $brokerage_id)
      ->get();

      $utility_types = DB::table('utility_types')
      ->select('bank_charges', 'other_charges', 'insurance_gc', 'insurance_c')
      ->get();

      $containerized_arrastre_header = DB::table('arrastre_headers')
      ->select('arrastre_headers.id', 'locations_id')
      ->where('locations_id', '=', $brokerage_header[0]->location_id)
      ->get();

      $containerized_arrastre_detail = DB::table('arrastre_details')
      ->select('container_sizes_id', 'amount', 'name as containerVolume')
      ->join('container_types', 'container_sizes_id', '=', 'container_types.id')
      ->where('arrastre_details.arrastre_header_id', '=', $containerized_arrastre_header[0]->id)
      ->get();

      $containerized_wharfage_header = DB::table('wharfage_headers')
      ->select('wharfage_headers.id', 'locations_id')
      ->where('locations_id', '=', $brokerage_header[0]->location_id)
      ->get();

      $containerized_wharfage_detail = DB::table('wharfage_details')
      ->select('container_sizes_id', 'amount', 'name as containerVolume')
      ->join('container_types', 'container_sizes_id', '=', 'container_types.id')
      ->where('wharfage_details.wharfage_header_id', '=', $containerized_wharfage_header[0]->id)
      ->get();

      $lcl_arrastre_header = DB::table('arrastre_lcl_headers')
      ->select('arrastre_lcl_headers.id', 'locations_id', 'dateEffective')
      ->where('locations_id', '=',  $brokerage_header[0]->location_id)
      ->get();

      $lcl_arrastre_detail = DB::table('arrastre_lcl_details')
      ->select('arrastre_lcl_details.id', 'lcl_types_id', 'lcl_types.name as lcl_type', 'basis_types_id', 'basis_types.name as basis_name', 'amount')
      ->join('lcl_types', 'lcl_types_id', '=', 'lcl_types.id')
      ->join('basis_types', 'basis_types_id', '=', 'basis_types.id')
      ->where('arrastre_lcl_details.arrastre_lcl_headers_id', '=', $lcl_arrastre_header[0]->id)
      ->get();

      $lcl_wharfage_header = DB::table('wharfage_lcl_headers')
      ->select('wharfage_lcl_headers.id', 'locations_id')
      ->where('locations_id', '=',  $brokerage_header[0]->location_id)
      ->get();

      $lcl_wharfage_detail = DB::table('wharfage_lcl_details')
      ->select('wharfage_lcl_details.id', 'basis_types_id', 'basis_types.name as basis_name','amount')
      ->join('basis_types', 'basis_types_id', '=', 'basis_types.id')
      ->where('wharfage_lcl_details.wharfage_lcl_headers_id', '=', $lcl_wharfage_header[0]->id)
      ->get();

      $dutiesandtaxes_header = DB::table('duties_and_taxes_headers')
      ->select('duties_and_taxes_headers.id', 'exchangeRate_id', 'cdsFee_id', 'ipfFee_id', 'arrastre', 'wharfage', 'bankCharges')
      ->where('brokerageServiceOrders_id','=', $brokerage_header[0]->id)
      ->get();

          $current_date = date("Y-m-d");

          $exchange_rate = DB::table('exchange_rates')
          ->select('id', 'rate', 'dateEffective')
          ->get();

          $row_count = count($exchange_rate);
          $dateEffective_temp = $current_date;
          $dateEffective_temp2 = $current_date;
          for($x = 0; $x < $row_count; $x++)
          {
            if(date_format(date_create($exchange_rate[$x]->dateEffective), "Y-m-d") <= $current_date)
            {

                if(date_format(date_create($exchange_rate[$x]->dateEffective), "Y-m-d") >= $dateEffective_temp)
                {
                  $dateEffective_temp = date_format(date_create($exchange_rate[$x]->dateEffective), "Y-m-d");
                  $currentExchange_id = $exchange_rate[$x]->id;
                }
                else {
                  $currentExchange_id = $exchange_rate[$x]->id;
                }
            }
          }


          $cds_fee = DB::table('cds_fees')
          ->select('id', 'fee', 'dateEffective')
          ->get();


          $row_count = count($cds_fee);
          $dateEffective_temp = $current_date;
          for($x = 0; $x < $row_count; $x++)
          {

            if(date_format(date_create($cds_fee[$x]->dateEffective), "Y-m-d") <= $current_date)
            {
              if(date_format(date_create($cds_fee[$x]->dateEffective), "Y-m-d") >= $dateEffective_temp)
              {
                $dateEffective_temp = date_format(date_create($cds_fee[$x]->dateEffective), "Y-m-d");
                $currentCds_id = $cds_fee[$x]->id;
              }
              else {
              $currentCds_id = $cds_fee[$x]->id;
              }
            }
          }

          $ipf_fee_header = DB::table('import_processing_fee_headers')
          ->select('id', 'dateEffective')
          ->get();

          $row_count = count($ipf_fee_header);
          $dateEffective_temp = $current_date;

          if($row_count > 0)
          {
            for($x = 0; $x < $row_count; $x++)
            {
              if(date_format(date_create($ipf_fee_header[$x]->dateEffective), "Y-m-d") <= $current_date)
              {
                if(date_format(date_create($ipf_fee_header[$x]->dateEffective), "Y-m-d") >= $dateEffective_temp)
                {
                  $dateEffective_temp = date_format(date_create($ipf_fee_header[$x]->dateEffective), "Y-m-d");

                  $currentIpf_id = $ipf_fee_header[$x]->id;
                }
                else {
                $currentIpf_id = $ipf_fee_header[$x]->id;
                }
              }
            }
          }
          else {
            $currentIpf_id = 0;
          }

          $ipf_fee_detail = DB::table('import_processing_fee_details')
          ->select('id', 'minimum', 'maximum', 'amount', 'ipf_headers_id')
          ->get();

          $brokerage_con = DB::Select('select brok_so_id from brokerage_containers where brok_so_id = '.$brokerage_id.'');

          if($brokerage_con != null)
          {
            $withContainer = true;
          }
          else
          {
            $withContainer = false;
          }

          $dangerous_cargo_types = DB::table('dangerous_cargo_types')
          ->select('dangerous_cargo_types.id', 'name')
          ->get();

          $delivery_details = [];
          if($withContainer == false){
              $brokerage_details = DB::table('brokerage_non_container_details')
              ->select('brokerage_service_orders.id', 'descriptionOfGoods', 'grossWeight', 'cubicMeters', 'lcl_types.name as lcl_type',  'basis_types.name as basis', 'supplier')
              ->join('brokerage_service_orders', 'brok_head_id', '=', 'brokerage_service_orders.id')
              ->join('lcl_types', 'lclType_id', '=', 'lcl_types.id')
              ->join('basis_types', 'basis', '=', 'basis_types.id')
              ->where('brok_head_id', '=', $brokerage_id)

              ->get();
          }
          else{
              $container_with_detail = [];
              $brokerage_containers = DB::table('brokerage_containers')
              ->join('brokerage_service_orders AS A', 'brok_so_id', 'A.id')
              ->where('brok_so_id', '=', $brokerage_id)
              ->select('brokerage_containers.id', 'containerNumber', 'containerVolume', 'containerReturnTo', 'containerReturnAddress', 'containerReturnDate', 'containerReturnStatus', 'dateReturned', 'brokerage_containers.remarks', 'cargoType', 'brok_so_id', 'shippingLine', 'portOfCfsLocation')

              ->get();
              foreach ($brokerage_containers as $container) {
                  $container_details =  DB::table('brokerage_container_details')
                  ->select('brokerage_container_details.id', 'descriptionOfGoods', 'grossWeight', 'class_id', 'supplier')
                  ->where('container_id', '=', $container->id)
                  ->get();

                  $new_row['container'] = $container;
                  $new_row['details'] = $container_details;
                  array_push($container_with_detail, $new_row);
              }
          }

      return view('brokerage.brokerage_dutiesandtaxes_create',compact(['brokerage_id', 'employees', 'current_date',  'row_count', 'currentExchange_id', 'exchange_rate', 'currentCds_id', 'cds_fee', 'currentIpf_id', 'ipf_fee_header', 'ipf_fee_detail', 'containerized_arrastre_header', 'containerized_arrastre_detail', 'containerized_wharfage_header', 'containerized_wharfage_detail', 'lcl_arrastre_header', 'lcl_arrastre_detail', 'lcl_wharfage_header', 'lcl_wharfage_detail', 'brokerage_header', 'withContainer', 'brokerage_details', 'brokerage_containers', 'container_with_detail', 'utility_types']));//
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $new_dutiesandtaxes = new DutiesAndTaxesHeader;
    $new_dutiesandtaxes->exchangeRate_id = $request->ExchangeRateId;
    $new_dutiesandtaxes->cdsFee_id = $request->CDSId;
    $new_dutiesandtaxes->ipfFee_id = $request->IPFId;
    $new_dutiesandtaxes->brokerageFee = $request->brokerageFee;
    $new_dutiesandtaxes->arrastre = $request->arrastre;
    $new_dutiesandtaxes->wharfage = $request->wharfage;
    $new_dutiesandtaxes->bankCharges = $request->bankCharges;
    $new_dutiesandtaxes->brokerageServiceOrders_id = $request->brokerage_id;
    $new_dutiesandtaxes->employees_id_broker = $request->employee_id;
    $new_dutiesandtaxes->statusType = 'P';
    $new_dutiesandtaxes->save();

    $_ItemName = json_decode(stripslashes($request->StoredItemName), true);
    $itemName = array();

    $_HSCode = json_decode(stripslashes($request->StoredHSCode), true);
    $HSCode;

    $_RateOfDuty = json_decode(stripslashes($request->StoredRateOfDuty), true);
    $RateOfDuty;

    $_Value = json_decode(stripslashes($request->StoredValue), true);
    $Value;

    $_Freight = json_decode(stripslashes($request->StoredFreight), true);
    $Freight;

    $_Insurance = json_decode(stripslashes($request->StoredInsurance), true);
    $Insurance;

    $_OtherCharges = json_decode(stripslashes($request->StoredOtherCharges), true);
    $Insurance;

    $tblRowLength = $request->tblRowLength;
    for ($x = 0; $x < $tblRowLength; $x++) {
      $new_dutiesandtaxes_details = new DutiesAndTaxesDetails;
      $new_dutiesandtaxes_details->dutiesAndTaxesHeaders_id = $new_dutiesandtaxes->id;
      $new_dutiesandtaxes_details->descriptionOfGoods = (string)$_ItemName[$x];
      $new_dutiesandtaxes_details->valueInUSD = (string)$_Value[$x];
      $new_dutiesandtaxes_details->insurance = (string)$_Insurance[$x];
      $new_dutiesandtaxes_details->freight = (string)$_Freight[$x];
      $new_dutiesandtaxes_details->otherCharges = (string)$_OtherCharges[$x];
      $new_dutiesandtaxes_details->hsCode = (string)$_HSCode[$x];
      $new_dutiesandtaxes_details->rateOfDuty = (string)$_RateOfDuty[$x];
      $new_dutiesandtaxes_details->save();
    }


    $brokerage_id = $new_dutiesandtaxes->id;
    return $brokerage_id;
    //
  }


  public function update_taxstatus(Request $request)
  {
      $brokerage_id = $request->brokerage_id;
      $brokerage_status_update = DB::table('duties_and_taxes_headers')
      ->where('duties_and_taxes_headers.id', $brokerage_id)
      ->update(['statusType' =>  $request->status]);

    return $brokerage_id;
  }

  public function generate_taxes(Request $request)
  {
    $consignee = $request->consignee;

    return view('brokerage.dutiesandtaxes_create', compact(['consignee']));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }


}
