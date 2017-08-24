<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\ConsigneeServiceOrderHeader;
use App\ConsigneeServiceOrderDetail;
use App\BrokerageServiceOrder;
use App\DutiesAndTaxesHeader;
use App\DutiesAndTaxesDetails;

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
  public function create()
  {

      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $new_so_head = new ConsigneeServiceOrderHeader;
    $new_so_head->consignees_id = $request->cs_id;
    $new_so_head->employees_id = "1";
    $new_so_head->save();

    $new_so_detail = new ConsigneeServiceOrderDetail;
    $new_so_detail->so_headers_id = $new_so_head->id;
    $new_so_detail->service_order_types_id = 1;
    $new_so_detail->save();

    $new_brokerage_so = new BrokerageServiceOrder;
    $new_brokerage_so->consigneeSODetails_id = $new_so_detail->id;
    $new_brokerage_so->shipper = $request->shipper;
    $new_brokerage_so->expectedArrivalDate = $request->arrivalDate;
    $new_brokerage_so->freightBillNo = $request->freightNumber;
    $new_brokerage_so->Weight = $request->weight;
    $new_brokerage_so->arrivalArea = $request->arrivalArea;
    $new_brokerage_so->freightType = $request->freightType;
    $new_brokerage_so->bi_head_id_rev = null;
    $new_brokerage_so->bi_head_id_exp = null;
    $new_brokerage_so->save();

    $new_dutiesandtaxes = new DutiesAndTaxesHeader;
    $new_dutiesandtaxes->exchangeRate_id = $request->ExchangeRateId;
    $new_dutiesandtaxes->cdsFee_id = $request->CDSId;
    $new_dutiesandtaxes->ipfFee_id = $request->IPFId;
    $new_dutiesandtaxes->brokerageFee = $request->brokerageFee;
    $new_dutiesandtaxes->arrastre = $request->arrastre;
    $new_dutiesandtaxes->wharfage = $request->wharfage;
      $new_dutiesandtaxes->bankCharges = $request->bankCharges;

    $new_dutiesandtaxes->brokerageServiceOrders_id = $new_brokerage_so->id;
    $new_dutiesandtaxes->employees_id_broker = 1;
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

    $brokerage_id = $new_brokerage_so->id;
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
}
