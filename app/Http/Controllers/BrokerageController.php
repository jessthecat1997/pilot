<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReceiveType;
use App\BrokerageServiceOrder;
use Illuminate\Support\Facades\DB;

class BrokerageController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
        return view('brokerage/brokerage_index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('brokerage/brokerage_create');
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
          ->select('duties_and_taxes_headers.id', 'exchangeRate')
          ->where('brokerageServiceOrders_id','=', $brokerage_header[0]->id)
          ->get();

          $dutiesandtaxes_details = DB::table('duties_and_taxes_details')
          ->select('duties_and_taxes_details.id', 'descriptionOfGoods' , 'valueInUSD' , 'insurance' , 'freight' , 'otherCharges' , 'hsCode' ,'rateOfDuty')
          ->where('dutiesAndTaxesHeaders_id','=', $dutiesandtaxes_header[0]->id)
          ->get();

          //dd($brokerage_header, $dutiesandtaxes_header, $dutiesandtaxes_details );
          return view('brokerage/brokerage_view', compact(['so_id',  'brokerage_header', 'dutiesandtaxes_header', 'dutiesandtaxes_details']));
      }
      catch(ModelNotFoundException $e)
      {
          return 'No service order';
      }
  }
}
