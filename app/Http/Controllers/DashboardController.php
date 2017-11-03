<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(Request $request)
  {
    $user = \Auth::user();
    $deliveries = \DB::table('delivery_receipt_headers')
    ->select('deliveryDateTime', 'pickupDateTime', 'trucking_service_orders.id as tr_so_id', 'plateNumber', 'delivery_receipt_headers.id as del_head_id')
    ->join('trucking_service_orders', 'delivery_receipt_headers.tr_so_id', '=', 'trucking_service_orders.id')
    ->whereRaw('delivery_receipt_headers.status IN("P", "F")')
    ->get();

    $delivery_status = \DB::select('SELECT COUNT(id) as pending FROM delivery_receipt_headers WHERE status = "P"');
    $today_deliveries = \DB::table('delivery_receipt_headers')
    ->select(
      'delivery_receipt_headers.id as del_id',
      \DB::raw('CONCAT(firstName, " ", lastName) as name'),
      'pickupDateTime',
      'deliveryDateTime',
      'E.address as address',
      'F.address as d_address',
      'G.name as city_name',
      'H.name as province_name',
      'I.name as dcity_name',
      'J.name as dprovince_name',
      'plateNumber')
    ->join('trucking_service_orders AS A', 'delivery_receipt_headers.tr_so_id', '=', 'A.id')
    ->join('consignee_service_order_details AS B', 'A.so_details_id', '=', 'B.id')
    ->join('consignee_service_order_headers AS C', 'B.so_headers_id', '=', 'C.id')
    ->join('consignees AS D', 'C.consignees_id', '=', 'D.id')
    ->join('locations AS E', 'delivery_receipt_headers.locations_id_pick', 'E.id')
    ->join('locations AS F', 'delivery_receipt_headers.locations_id_del', 'F.id')
    ->join('location_cities as G', 'E.cities_id', 'G.id')
    ->join('location_provinces AS H', 'G.provinces_id', 'H.id')
    ->join('location_cities as I', 'F.cities_id', 'I.id')
    ->join('location_cities as J', 'I.provinces_id', 'J.id')
    ->where('delivery_receipt_headers.status', '=', 'P')
    ->whereRaw('DATE(pickupDateTime) = CURRENT_DATE')
    ->get();

    $unreturned_containers = \DB::table('delivery_containers')
    ->where('dateReturned', '=', null)
    ->get();


    return view('dashboard', compact(['deliveries', 'delivery_status', 'today_deliveries', 'unreturned_containers', 'user']));
  }
  public function permission_access_denied(Request $request)
  {
    $user = \Auth::user();
    return view('errors.access_denied', compact(['user']));
  }

  public function create()
  {
        //
  }


  public function store(Request $request)
  {
        //
  }


  public function show($id)
  {
        //
  }


  public function edit($id)
  {
        //
  }


  public function update(Request $request, $id)
  {
        //
  }


  public function destroy($id)
  {
        //
  }
}
