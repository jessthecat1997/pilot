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
      ->select('brokerage_service_orders.id', 'companyName', 'name', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight', 'freightType')
      ->join('consignee_service_order_details', 'consigneeSODetails_id', '=', 'consignee_service_order_details.id')
      ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
      ->join('consignees', 'consignees_id', '=', 'consignees.id')
      ->join('locations', 'location_id', '=', 'locations.id')
      ->where('brokerage_service_orders.id','=', $brokerage_id)
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

          $ipf_fee_detail = DB::table('import_processing_fee_details')
          ->select('id', 'minimum', 'maximum', 'amount', 'ipf_headers_id')
          ->get();

      return view('brokerage.brokerage_dutiesandtaxes_create',compact(['brokerage_id', 'employees', 'current_date',  'row_count', 'currentExchange_id', 'exchange_rate', 'currentCds_id', 'cds_fee', 'currentIpf_id', 'ipf_fee_header', 'ipf_fee_detail', 'brokerage_header']));//
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

    $tblRowLength = $request->tblRowLength;
    for ($x = 0; $x < $tblRowLength; $x++) {
      $new_dutiesandtaxes_details = new DutiesAndTaxesDetails;
      $new_dutiesandtaxes_details->dutiesAndTaxesHeaders_id = $new_dutiesandtaxes->id;
      $new_dutiesandtaxes_details->descriptionOfGoods = (string)$_ItemName[$x];
      $new_dutiesandtaxes_details->valueInUSD = (string)$_Value[$x];
      $new_dutiesandtaxes_details->insurance = (string)$_Insurance[$x];
      $new_dutiesandtaxes_details->freight = (string)$_Freight[$x];
      $new_dutiesandtaxes_details->hsCode = (string)$_HSCode[$x];
      $new_dutiesandtaxes_details->rateOfDuty = (string)$_RateOfDuty[$x];
      $new_dutiesandtaxes_details->save();
    }


    $brokerage_id = $new_dutiesandtaxes->id;
    return $brokerage_id;
    //
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

  public function update_taxstatus(Request $request)
  {
      $brokerage_id = $request->brokerage_id;
      $brokerage_status_update = DB::table('duties_and_taxes_headers')
      ->where('duties_and_taxes_headers.id', $brokerage_id)
    ->update(['statusType' =>  $request->status]);

    return $brokerage_id;
  }
}
