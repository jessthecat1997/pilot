<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ShipmentReportsController extends Controller
{
    public function index()
    {

      $brokerage_header = DB::table('brokerage_service_orders')
      ->select('brokerage_service_orders.id as order_no', 'employees.firstName as firstName', 'employees.lastName as lastName', 'companyName', 'name', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight', 'withCO', 'consignee_service_order_headers.created_at as dateCreated', 'bi_head_id_exp', 'bi_head_id_rev')
      ->join('consignee_service_order_details', 'consigneeSODetails_id', '=', 'consignee_service_order_details.id')
      ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
      ->join('consignees', 'consignees_id', '=', 'consignees.id')
      ->join('employees', 'employees_id', '=', 'employees.id')
      ->join('locations', 'location_id', '=', 'locations.id')
      ->get();

      $delivery_details = [];

          $brokerage_details = DB::table('brokerage_non_container_details')
          ->select('brokerage_service_orders.id', 'descriptionOfGoods', 'grossWeight', 'cubicMeters', 'lcl_types.name as lcl_type',  'basis_types.name as basis', 'supplier', 'brok_head_id')
          ->join('brokerage_service_orders', 'brok_head_id', '=', 'brokerage_service_orders.id')
          ->join('lcl_types', 'lclType_id', '=', 'lcl_types.id')
          ->join('basis_types', 'basis', '=', 'basis_types.id')
          ->get();

          $container_with_detail = [];
          $brokerage_containers = DB::table('brokerage_containers')
          ->join('brokerage_service_orders AS A', 'brok_so_id', 'A.id')
          ->select('brokerage_containers.id', 'containerNumber', 'containerVolume', 'containerReturnTo', 'containerReturnAddress', 'containerReturnDate', 'containerReturnStatus', 'dateReturned', 'brokerage_containers.remarks', 'cargoType', 'brok_so_id', 'shippingLine', 'portOfCfsLocation')

          ->get();
          foreach ($brokerage_containers as $container) {
              $container_details =  DB::table('brokerage_container_details')
              ->select('brokerage_container_details.id', 'descriptionOfGoods', 'grossWeight', 'class_id', 'supplier')
              ->get();

              $new_row['container'] = $container;
              $new_row['details'] = $container_details;
              array_push($container_with_detail, $new_row);
          }


        $payments = DB::table('payments')
        ->select('payments.id', 'payments.amount as payment_amount', 'payments.bi_head_id', 'so_head_id', 'billing_invoice_details.amount as charge_payment', 'charges.name as charge_name')
        ->join('billing_invoice_headers', 'payments.bi_head_id', '=', 'billing_invoice_headers.id')
        ->join('billing_invoice_details', 'payments.bi_head_id', '=', 'billing_invoice_details.id')
        ->join('charges', 'charge_id', '=', 'charges.id')
        ->get();

        $arrastres = DB::select('SELECT SUM(dt_hed.arrastre) as arrastre_sum, brok_ord.id as so_head_id from brokerage_service_orders brok_ord INNER JOIN duties_and_taxes_headers dt_hed ON dt_hed.brokerageServiceOrders_id = brok_ord.id where dt_hed.statusType = "A" GROUP BY brok_ord.id');

      return view('reports/shipment_index', compact(['brokerage_header', 'brokerage_details', 'brokerage_containers', 'container_details', 'payments', 'arrastres']));
    }

    public function print(Request $request){
        try
        {
          $frequency = $request->frequency;
          $brokerage_header = DB::table('brokerage_service_orders')
          ->select('brokerage_service_orders.id as order_no', 'employees.firstName as firstName', 'employees.lastName as lastName', 'companyName', 'name', 'expectedArrivalDate', 'shipper', 'freightBillNo', 'Weight', 'withCO', 'consignee_service_order_headers.created_at as dateCreated', 'bi_head_id_exp', 'bi_head_id_rev')
          ->join('consignee_service_order_details', 'consigneeSODetails_id', '=', 'consignee_service_order_details.id')
          ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
          ->join('consignees', 'consignees_id', '=', 'consignees.id')
          ->join('employees', 'employees_id', '=', 'employees.id')
          ->join('locations', 'location_id', '=', 'locations.id')
          ->get();

          $delivery_details = [];

              $brokerage_details = DB::table('brokerage_non_container_details')
              ->select('brokerage_service_orders.id', 'descriptionOfGoods', 'grossWeight', 'cubicMeters', 'lcl_types.name as lcl_type',  'basis_types.name as basis', 'supplier', 'brok_head_id')
              ->join('brokerage_service_orders', 'brok_head_id', '=', 'brokerage_service_orders.id')
              ->join('lcl_types', 'lclType_id', '=', 'lcl_types.id')
              ->join('basis_types', 'basis', '=', 'basis_types.id')
              ->get();

              $container_with_detail = [];
              $brokerage_containers = DB::table('brokerage_containers')
              ->join('brokerage_service_orders AS A', 'brok_so_id', 'A.id')
              ->select('brokerage_containers.id', 'containerNumber', 'containerVolume', 'containerReturnTo', 'containerReturnAddress', 'containerReturnDate', 'containerReturnStatus', 'dateReturned', 'brokerage_containers.remarks', 'cargoType', 'brok_so_id', 'shippingLine', 'portOfCfsLocation')

              ->get();
              foreach ($brokerage_containers as $container) {
                  $container_details =  DB::table('brokerage_container_details')
                  ->select('brokerage_container_details.id', 'descriptionOfGoods', 'grossWeight', 'class_id', 'supplier')
                  ->get();

                  $new_row['container'] = $container;
                  $new_row['details'] = $container_details;
                  array_push($container_with_detail, $new_row);
              }


            $payments = DB::table('payments')
            ->select('payments.id', 'payments.amount as payment_amount', 'payments.bi_head_id', 'so_head_id', 'billing_invoice_details.amount as charge_payment', 'charges.name as charge_name')
            ->join('billing_invoice_headers', 'payments.bi_head_id', '=', 'billing_invoice_headers.id')
            ->join('billing_invoice_details', 'payments.bi_head_id', '=', 'billing_invoice_details.id')
            ->join('charges', 'charge_id', '=', 'charges.id')
            ->get();

            $arrastres = DB::select('SELECT SUM(dt_hed.arrastre) as arrastre_sum, brok_ord.id as so_head_id from brokerage_service_orders brok_ord INNER JOIN duties_and_taxes_headers dt_hed ON dt_hed.brokerageServiceOrders_id = brok_ord.id where dt_hed.statusType = "A" GROUP BY brok_ord.id');


            $pdf = PDF::loadView('pdf_layouts.shipments_report_pdf', compact(['brokerage_header', 'brokerage_details', 'brokerage_containers', 'container_details', 'payments', 'arrastres', 'frequency']))->setPaper('a4', 'landscape')->setWarnings(false);
            return $pdf->stream();
        }
        catch(ModelNotFoundException $e)
        {
            return 'No service order';
        }
    }


}
