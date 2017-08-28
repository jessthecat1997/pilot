<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReceiveType;
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\ConsigneeServiceOrderHeader;
use App\ConsigneeServiceOrderDetail;
use App\BrokerageServiceOrder;
use App\DutiesAndTaxesHeader;
use App\DutiesAndTaxesDetails;
use PDF;

class BrokerageController extends Controller
{

  public function index()
  {

    return view('brokerage/brokerage_index');
  }


  public function create()
  {

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



          //dd($brokerage_header, $dutiesandtaxes_header, $dutiesandtaxes_details );
          return view('brokerage/brokerage_create', compact(['current_date',  'row_count', 'currentExchange_id', 'exchange_rate', 'currentCds_id', 'cds_fee', 'currentIpf_id', 'ipf_fee_header', 'ipf_fee_detail']));
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

          $dutiesandtaxes_header = DB::table('duties_and_taxes_headers')
          ->select('duties_and_taxes_headers.id', 'exchangeRate_id', 'cdsFee_id', 'ipfFee_id', 'arrastre', 'wharfage', 'bankCharges', 'brokerageServiceOrders_id')
          ->where('duties_and_taxes_headers.id','=', $so_id)
          ->get();

          $brokerage_header = DB::table('brokerage_service_orders')
          ->select('brokerage_service_orders.id', 'companyName', 'name', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight')
          ->join('consignee_service_order_details', 'consigneeSODetails_id', '=', 'consignee_service_order_details.id')
          ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
          ->join('consignees', 'consignees_id', '=', 'consignees.id')
          ->join('locations', 'location_id', '=', 'locations.id')
          ->where('brokerage_service_orders.id','=',   $dutiesandtaxes_header[0]->brokerageServiceOrders_id)
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

            $dutiesandtaxes_header = DB::table('duties_and_taxes_headers')
            ->select('duties_and_taxes_headers.id', 'exchangeRate_id', 'brokerageFee', 'cdsFee_id', 'ipfFee_id', 'arrastre', 'wharfage', 'bankCharges', 'brokerageServiceOrders_id')
            ->where('duties_and_taxes_headers.id','=', $so_id)
            ->get();

            $brokerage_header = DB::table('brokerage_service_orders')
            ->select('brokerage_service_orders.id', 'companyName', 'name', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight')
            ->join('consignee_service_order_details', 'consigneeSODetails_id', '=', 'consignee_service_order_details.id')
            ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
            ->join('consignees', 'consignees_id', '=', 'consignees.id')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->where('brokerage_service_orders.id','=',   $dutiesandtaxes_header[0]->brokerageServiceOrders_id)
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

  public function create_new()
  {
    $employees = Employee::all();

    $consignees = \App\Consignee::all();

    $provinces = \App\LocationProvince::all();

    $locations = \App\Location::all();

      return view('brokerage/brokerage_dutiesandtaxes', compact(['employees', 'consignees', 'provinces', 'locations']));
  }

  public function save_neworder(Request $request)
  {
    $new_so_head = new ConsigneeServiceOrderHeader;
    $new_so_head->consignees_id = $request->cs_id;
    $new_so_head->employees_id = $request->employee_id;
    $new_so_head->save();

    $new_so_detail = new ConsigneeServiceOrderDetail;
    $new_so_detail->so_headers_id = $new_so_head->id;
    $new_so_detail->service_order_types_id = 1;
    $new_so_detail->save();

    $date = date_format(date_create($request->arrivalDate),"Y-m-d");
    $new_brokerage_so = new BrokerageServiceOrder;
    $new_brokerage_so->consigneeSODetails_id = $new_so_detail->id;
    $new_brokerage_so->shipper = $request->shipper;
    $new_brokerage_so->expectedArrivalDate = $date;
    $new_brokerage_so->location_id = $request->location_id;
    $new_brokerage_so->freightBillNo = $request->freightNumber;
    $new_brokerage_so->Weight = $request->weight;
    $new_brokerage_so->freightType = $request->freightType;
    $new_brokerage_so->statusType = 'P';
    $new_brokerage_so->bi_head_id_rev = null;
    $new_brokerage_so->bi_head_id_exp = null;
    $new_brokerage_so->save();

    $brokerage_id = $new_brokerage_so->id;
    return $brokerage_id;
  }

  public function view_order(Request $request)
  {
    $brokerage_id = $request->brokerage_id;

    $brokerage_header = DB::table('brokerage_service_orders')
    ->select('brokerage_service_orders.id', 'companyName', 'name', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight', 'location_id', 'firstName', 'middleName', 'lastName', 'statusType')
    ->join('consignee_service_order_details', 'consigneeSODetails_id', '=', 'consignee_service_order_details.id')
    ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
    ->join('consignees', 'consignees_id', '=', 'consignees.id')
    ->join('locations', 'location_id', '=', 'locations.id')
    ->where('brokerage_service_orders.id','=', $brokerage_id)
    ->get();

    $dutiesandtaxes_header = DB::table('duties_and_taxes_headers')
    ->select('duties_and_taxes_headers.id', 'brokerageFee')
    ->where('brokerageServiceOrders_id', '=', $brokerage_id)
    ->get();


    return view('brokerage/brokerage_view_index', compact(['brokerage_id', 'brokerage_header', 'dutiesandtaxes_header']));
  }

  public function update_status(Request $request)
  {
      $brokerage_id = $request->brokerage_id;
      $brokerage_status_update = DB::table('brokerage_service_orders')
      ->where('brokerage_service_orders.id', $brokerage_id)
    ->update(['statusType' =>  $request->status]);

    return $brokerage_id;
  }
}
