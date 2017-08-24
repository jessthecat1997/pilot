<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReceiveType;
use App\BrokerageServiceOrder;
use Illuminate\Support\Facades\DB;

use PDF;

class BrokerageController extends Controller
{

  public function index()
  {

    return view('brokerage/brokerage_index');
  }


  public function create()
  {
    $consignees = \App\Consignee::all();
    $provinces = \App\LocationProvince::all();
    try
    {
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




      return view('brokerage/brokerage_create', compact(['current_date',  'row_count', 'currentExchange_id', 'exchange_rate', 'currentCds_id', 'cds_fee', 'currentIpf_id', 'ipf_fee_header', 'ipf_fee_detail', 'consignees', 'provinces']));
    }
    catch(ModelNotFoundException $e)
    {

    }

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

  public function view_brokerage(Request $request){
    try
    {
      $so_id = $request->brokerage_id;

      $brokerage_header = DB::table('brokerage_service_orders')
      ->select('brokerage_service_orders.id', 'companyName', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight', 'arrivalArea')
      ->join('consignee_service_order_details', 'consigneeSODetails_id', '=', 'consignee_service_order_details.id')
      ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
      ->join('consignees', 'consignees_id', '=', 'consignees.id')
      ->where('brokerage_service_orders.id','=', $so_id)
      ->get();


      $dutiesandtaxes_header = DB::table('duties_and_taxes_headers')
      ->select('duties_and_taxes_headers.id', 'exchangeRate_id', 'cdsFee_id', 'ipfFee_id', 'arrastre', 'wharfage', 'bankCharges')
      ->where('brokerageServiceOrders_id','=', $brokerage_header[0]->id)
      ->get();

      $exchangeRate = DB::table('exchange_rates')
      ->select('exchange_rates.id', 'rate')
      ->where('exchange_rates.id', '=',$dutiesandtaxes_header[0]->exchangeRate_id)
      ->get();

      $cds_fee = DB::table('cds_fees')
      ->select('cds_fees.id', 'fee')
      ->where('cds_fees.id', '=',$dutiesandtaxes_header[0]->cdsFee_id)
      ->get();

      $ipf_fee_header = DB::table('import_processing_fee_headers')
      ->select('import_processing_fee_headers.id', 'dateEffective')
      ->where('import_processing_fee_headers.id', '=',$dutiesandtaxes_header[0]->ipfFee_id)
      ->get();

      $ipf_fee_details = DB::table('import_processing_fee_details')
      ->select('import_processing_fee_details.id', 'minimum', 'maximum', 'amount')
      ->where('import_processing_fee_details.id', '=',$dutiesandtaxes_header[0]->ipfFee_id)
      ->get();

      $dutiesandtaxes_details = DB::table('duties_and_taxes_details')
      ->select('duties_and_taxes_details.id', 'descriptionOfGoods' , 'valueInUSD' , 'insurance' , 'freight' , 'otherCharges' , 'hsCode' ,'rateOfDuty')
      ->where('dutiesAndTaxesHeaders_id','=', $dutiesandtaxes_header[0]->id)
      ->get();


      return view('brokerage/brokerage_view', compact(['so_id',  'brokerage_header', 'dutiesandtaxes_header', 'dutiesandtaxes_details', 'exchangeRate', 'cds_fee', 'ipf_fee_header', 'ipf_fee_details']));
    }
    catch(ModelNotFoundException $e)
    {
      return 'No service order';
    }
  }


  public function print(Request $request){
    try
    {
      $so_id = $request->brokerage_id;

      $brokerage_header = DB::table('brokerage_service_orders')
      ->select('brokerage_service_orders.id', 'companyName', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight', 'arrivalArea')
      ->join('consignee_service_order_details', 'consigneeSODetails_id', '=', 'consignee_service_order_details.id')
      ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
      ->join('consignees', 'consignees_id', '=', 'consignees.id')
      ->where('brokerage_service_orders.id','=', $so_id)
      ->get();


      $dutiesandtaxes_header = DB::table('duties_and_taxes_headers')
      ->select('duties_and_taxes_headers.id', 'exchangeRate_id', 'brokerageFee', 'cdsFee_id', 'ipfFee_id', 'arrastre', 'wharfage', 'bankCharges')
      ->where('brokerageServiceOrders_id','=', $brokerage_header[0]->id)
      ->get();

      $exchangeRate = DB::table('exchange_rates')
      ->select('exchange_rates.id', 'rate')
      ->where('exchange_rates.id', '=',$dutiesandtaxes_header[0]->exchangeRate_id)
      ->get();

      $cds_fee = DB::table('cds_fees')
      ->select('cds_fees.id', 'fee')
      ->where('cds_fees.id', '=',$dutiesandtaxes_header[0]->cdsFee_id)
      ->get();

      $ipf_fee_header = DB::table('import_processing_fee_headers')
      ->select('import_processing_fee_headers.id', 'dateEffective')
      ->where('import_processing_fee_headers.id', '=',$dutiesandtaxes_header[0]->ipfFee_id)
      ->get();

      $ipf_fee_details = DB::table('import_processing_fee_details')
      ->select('import_processing_fee_details.id', 'minimum', 'maximum', 'amount')
      ->where('import_processing_fee_details.id', '=',$dutiesandtaxes_header[0]->ipfFee_id)
      ->get();

      $dutiesandtaxes_details = DB::table('duties_and_taxes_details')
      ->select('duties_and_taxes_details.id', 'descriptionOfGoods' , 'valueInUSD' , 'insurance' , 'freight' , 'otherCharges' , 'hsCode' ,'rateOfDuty')
      ->where('dutiesAndTaxesHeaders_id','=', $dutiesandtaxes_header[0]->id)
      ->get();

      $pdf = PDF::loadView('pdf_layouts.dutiesandtaxes_pdf', compact(['so_id',  'brokerage_header', 'dutiesandtaxes_header', 'dutiesandtaxes_details', 'exchangeRate', 'cds_fee', 'ipf_fee_header', 'ipf_fee_details']))->setPaper('a4', 'landscape')->setWarnings(false);
      return $pdf->stream();
    }
    catch(ModelNotFoundException $e)
    {
      return 'No service order';
    }
  }
}
