<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Facades\Datatables;
use Illuminate\Http\Request;
use App\ReceiveType;
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\ConsigneeServiceOrderHeader;
use App\ConsigneeServiceOrderDetail;
use App\BrokerageServiceOrder;
use App\DutiesAndTaxesHeader;
use App\DutiesAndTaxesDetails;
use App\BrokerageContainer;
use App\BrokerageContainerDetails;
use App\BrokerageNonContainerDetails;
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


      //vanessa's addition

       $consignee_id = $request->session()->get('consignees_id');
       return $consignee_id;

      //end of vanessa's addition

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
          ->select('brokerage_service_orders.id', 'companyName', 'name', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight', 'withCO', 'bi_head_id_exp', 'bi_head_id_rev')
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
            ->where('import_processing_fee_details.ipf_headers_id', '=',$dutiesandtaxes_header[0]->ipfFee_id)
            ->get();

          $dutiesandtaxes_details = DB::table('duties_and_taxes_details')
          ->select('duties_and_taxes_details.id', 'descriptionOfGoods' , 'valueInUSD' , 'insurance' , 'freight' , 'otherCharges' , 'hsCode' ,'rateOfDuty')
          ->where('dutiesAndTaxesHeaders_id','=', $dutiesandtaxes_header[0]->id)
          ->get();

          $brokerage_container = false;
          return view('brokerage/brokerage_view', compact(['so_id',  'brokerage_header', 'dutiesandtaxes_header', 'dutiesandtaxes_details', 'exchangeRate', 'cds_fee', 'ipf_fee_header', 'ipf_fee_details', 'brokerage_container']));
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
            ->where('import_processing_fee_details.ipf_headers_id', '=',$dutiesandtaxes_header[0]->ipfFee_id)
            ->get();

          $dutiesandtaxes_details = DB::table('duties_and_taxes_details')
          ->select('duties_and_taxes_details.id', 'descriptionOfGoods' , 'valueInUSD' , 'insurance' , 'freight' , 'otherCharges' , 'hsCode' ,'rateOfDuty')
          ->where('dutiesAndTaxesHeaders_id','=', $dutiesandtaxes_header[0]->id)
          ->get();

          $audit = new \App\AuditTrail;
          $audit->user_id = \Auth::user()->id;
          $audit->description = "Printed duties and taxes declartion, id: " . $dutiesandtaxes_header[0]->id . " from brokerage order no: " .$dutiesandtaxes_header[0]->brokerageServiceOrders_id;
          $audit->save();

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

    $provinces = DB::table('location_provinces')
    ->select('id', 'name')
    ->where('deleted_at', '=', null)
		->get();

    $locations = DB::table('locations')
    ->select('id', 'name', 'address', 'zipCode', 'cities_id')
    ->where('deleted_at', '=', null)
		->get();

    $dangerous_types = DB::table('dangerous_cargo_types')
    ->select('id', 'name')
    ->where('deleted_at', '=', null)
    ->get();

    $lcl_types = DB::table('lcl_types')
		->select('id', 'name')
		->where('deleted_at', '=', null)
		->get();

    $basis = DB::table('basis_types')
    ->select('id', 'name', 'abbreviation')
		->where('deleted_at', '=', null)
		->get();

    $container_volumes = DB::table('container_types')
    ->select('id', 'name', 'maxWeight')
    ->where('deleted_at', '=', null)
		->get();

      return view('brokerage/brokerage_dutiesandtaxes', compact(['employees', 'consignees', 'provinces', 'locations', 'container_volumes', 'lcl_types', 'basis', 'dangerous_types']));
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

    $new_brokerage_so->withCO = $request->withCO;
    $new_brokerage_so->bi_head_id_rev = null;
    $new_brokerage_so->bi_head_id_exp = null;
    $new_brokerage_so->save();

    if($request->containerNumber == null)
    {
      for($i = 0; $i < count($request->descrp_goods); $i++)
      {
          $new_nonbro_detail = new BrokerageNonContainerDetails;
          $new_nonbro_detail->descriptionOfGoods = $request->descrp_goods[$i];
          $new_nonbro_detail->grossWeight = $request->gross_weights[$i];
          $new_nonbro_detail->cubicMeters = $request->cbm[$i];
          $new_nonbro_detail->supplier = $request->suppliers[$i];
          $new_nonbro_detail->lclType_id = $request->lcl_types[$i];
          $new_nonbro_detail->basis = $request->basis[$i];
          $new_nonbro_detail->brok_head_id = $new_brokerage_so->id;

          $new_nonbro_detail->save();
      }
    }
    else{
        $response = "";

        $data = json_decode($request->container_data);
        foreach ($data as $container => $value)
        {
            $container = json_decode((string)json_encode($value));
            foreach ($container as $key => $container_detail)
            {
                $new_brokerage_container = new BrokerageContainer;

                $new_brokerage_container->containerNumber = $container_detail->container[0]->containerNumber;
                $new_brokerage_container->containerVolume = $container_detail->container[0]->containerVolume;
                $new_brokerage_container->shippingLine = $container_detail->container[0]->shippingLine;
                $new_brokerage_container->portOfCfsLocation = $container_detail->container[0]->portOfCfsLocation;
                $new_brokerage_container->containerReturnTo = $container_detail->container[0]->containerReturnTo;
                $new_brokerage_container->containerReturnAddress = $container_detail->container[0]->containerReturnAddress;
                $new_brokerage_container->containerReturnDate = $container_detail->container[0]->containerReturnDate;
                $new_brokerage_container->cargoType = $container_detail->container[0]->cargoType;
                $new_brokerage_container->containerReturnStatus = "N";
                $new_brokerage_container->dateReturned = null;
                $new_brokerage_container->remarks = "";
                $new_brokerage_container->brok_so_id = $new_brokerage_so->id;

                $new_brokerage_container->save();

                foreach ($container_detail->details as $key => $container_detail_data){

                    $new_brokerage_container_detail = new BrokerageContainerDetails;
                    $new_brokerage_container_detail->descriptionOfGoods = $container_detail_data->descriptionOfGood;
                    $new_brokerage_container_detail->grossWeight = $container_detail_data->grossWeight;
                    $new_brokerage_container_detail->supplier = $container_detail_data->supplier;
                    $new_brokerage_container_detail->container_id = $new_brokerage_container->id;

                    if($container_detail->container[0]->cargoType == 'D')
                    {
                      $new_brokerage_container_detail->class_id = $container_detail_data->class;
                    }
                    $new_brokerage_container_detail->save();
                    $response .= $container_detail_data->descriptionOfGood;
                }

            }
        }
    }

    $audit = new \App\AuditTrail;
    $audit->user_id = \Auth::user()->id;
    $audit->description = "Created new brokerage order id: ".$new_brokerage_so->id;
    $audit->save();

    $brokerage_id = $new_brokerage_so->id;
    return $brokerage_id;
  }

  public function view_order(Request $request)
  {
    $bill_revs = DB::table('charges')
    ->select('id','name', 'amount')
    ->where('bill_type', '=', 'R')
    ->where('deleted_at', '=', null)
    ->get();

    $bill_exps = DB::table('charges')
    ->select('id','name', 'amount')
    ->where('bill_type', '=', 'E')
    ->where('deleted_at', '=', null)
    ->get();

    $brokerage_id = $request->brokerage_id;

    $brokerage_header = DB::table('brokerage_service_orders')
    ->select('brokerage_service_orders.id', 'companyName', 'consignees.id as consigneeid', 'locations.name as location', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight', 'location_id', 'firstName', 'middleName', 'lastName', 'statusType', 'withCO', 'bi_head_id_rev', 'bi_head_id_exp')
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

    $brokerage_fees = DB::Select('select dt_hed.id as duty_header_id, dt_hed.created_at as createdat, dt_hed.brokerageFee from duties_and_taxes_headers dt_hed where dt_hed.brokerageServiceOrders_id = '.$brokerage_id.' AND not exists(select or_rev.order_brokerage_id from order_billed_revenues or_rev where dt_hed.id = or_rev.order_brokerage_id) AND dt_hed.StatusType = "A" ORDER BY dt_hed.brokerageServiceOrders_id');

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

    return view('brokerage/brokerage_view_index', compact(['brokerage_id', 'brokerage_header', 'dutiesandtaxes_header', 'bill_revs', 'bill_exps', 'brokerage_fees', 'withContainer', 'brokerage_details', 'brokerage_containers', 'container_with_detail', 'dangerous_cargo_types']));
  }

  public function get_approveddutiesandtaxes(Request $request)
  {
    $brokerage_id = $request->brokerage_id;

    $brokerage_fees = DB::Select('select dt_hed.id as duty_header_id, dt_hed.created_at as created_at, dt_hed.brokerageFee as amount from duties_and_taxes_headers dt_hed where dt_hed.brokerageServiceOrders_id = '.$brokerage_id.' AND not exists(select or_rev.order_brokerage_id from order_billed_revenues or_rev where dt_hed.id = or_rev.order_brokerage_id) AND dt_hed.StatusType = "A" ORDER BY dt_hed.brokerageServiceOrders_id');

    return Datatables::of($brokerage_fees)
    ->addColumn('action', function ($brokerage_fee){
      return
      '<button type="button" style="margin-right:10px; width:100;" class="btn btn-md btn-info selectedBrokerage"  value = '.$brokerage_fee->duty_header_id.' ><i class="fa fa-edit"></i>Select</button>';
    })
    ->make(true);

  }

  public function update_status(Request $request)
  {
      $brokerage_id = $request->brokerage_id;
      $brokerage_status_update = DB::table('brokerage_service_orders')
      ->where('brokerage_service_orders.id', $brokerage_id)
      ->update(['statusType' =>  $request->status]);


        $audit = new \App\AuditTrail;
        $audit->user_id = \Auth::user()->id;
        $audit->description = "Update brokerage order id: ".$brokerage_id;
        $audit->save();

    return $brokerage_id;
  }

  public function create_br_billing_header(Request $request){
      $consignee_order = \DB::table('consignee_service_order_headers')
      ->join('consignee_service_order_details AS A', 'A.so_headers_id', '=', 'consignee_service_order_headers.id')
      ->join('brokerage_service_orders AS B', 'B.consigneeSODetails_id', '=', 'A.id')
      ->select('consignee_service_order_headers.id')
      ->where('B.id', '=', $request->br_so_id)
      ->get();

      $vat = DB::select('SELECT rate FROM vat_rates where currentRate = 1');
      $billing_header = new \App\BillingInvoiceHeader;
      $billing_header->so_head_id = $consignee_order[0]->id;
      $billing_header->isRevenue = $request->isRevenue;
      $billing_header->vatRate = $vat[0]->rate;
      $billing_header->status = 'U';
      $billing_header->date_billed = \Carbon\Carbon::now();
      $billing_header->override_date = null;
      $billing_header->due_date = null;
      $billing_header->save();


      $consignee_header = \App\BrokerageServiceOrder::findOrFail($request->br_so_id);
      switch ($request->isRevenue) {
          case 0:
          $consignee_header->bi_head_id_exp = $billing_header->id;
              $audit = new \App\AuditTrail;
              $audit->user_id = \Auth::user()->id;
              $audit->description = "Created Refundable Charges Invoice for brokerage order id:" .$request->br_so_id;
              $audit->save();
          break;
          case 1:
          $consignee_header->bi_head_id_rev = $billing_header->id;
              $audit = new \App\AuditTrail;
              $audit->user_id = \Auth::user()->id;
              $audit->description = "Created Billing Invoice for brokerage order id:" .$request->br_so_id;
              $audit->save();
          break;
          default:
              # code...
          break;
      }



      $consignee_header->save();
      return $consignee_header;

  }
}
