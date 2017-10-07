<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\TruckingServiceOrder;
use App\Employee;
use App\ConsigneeServiceOrderHeader;
use App\ConsigneeServiceOrderDetail;
use App\ContainerType;
use App\Vehicle;
use App\VehicleType;
use App\DeliveryContainer;
use App\DeliveryReceiptHeader;
use App\DeliveryNonContainerDetail;
use App\DeliveryContainerDetail;
use App\ContractHeader;
use App\ContractDetails;
use App\Charge;
use App\DeliveryBilling;
use Response;
use PDF;
use App;

class TruckingsController extends Controller
{

    public function index()
    {
        $truckings = DB::table('trucking_service_orders')
        ->select(
            'trucking_service_orders.id',
            'companyName',
            'status',
            DB::raw('CONCAT(firstName, " ", lastName) AS name'))
        ->join('consignee_service_order_details', 'so_details_id', '=', 'consignee_service_order_details.id')
        ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
        ->join('consignees', 'consignees_id', '=', 'consignees.id')
        ->where('trucking_service_orders.status', '!=', ['F', 'C'])
        ->get();

        return view('trucking.trucking_service_order_index', compact(['truckings']));
    }


    public function create()
    {


        $employees = Employee::all();

        $consignees = \App\Consignee::all();

        $provinces = \App\LocationProvince::all();

        return view('trucking.trucking_service_order_create', compact(['employees', 'consignees', 'provinces']));
    }

    
    public function store(Request $request)
    {
        $new_so_head = new ConsigneeServiceOrderHeader;
        $new_so_head->consignees_id = $request->consignees_id;
        $new_so_head->employees_id = $request->processedBy;
        $new_so_head->save();


        $new_so_detail = new ConsigneeServiceOrderDetail;
        $new_so_detail->so_headers_id = $new_so_head->id;
        $new_so_detail->service_order_types_id = 2;
        $new_so_detail->save();

        $new_trucking  = new TruckingServiceOrder;
        $new_trucking->status = "P";
        $new_trucking->bi_head_id_rev = null;
        $new_trucking->bi_head_id_exp = null;
        $new_trucking->so_details_id = $new_so_detail->id;
        $new_trucking->save();

        return $new_trucking;
    }


    public function update(Request $request, $id)
    {
        $trucking_so = TruckingServiceOrder::findOrFail($id);
        $trucking_so->status = $request->status;

        $trucking_so->save();
    }

    public function destroy($id)
    {
        //
    }

    public function show_trucks(){
        $vehicle_type = VehicleType::all();
        $vehicle_type_with_vehicles = [];
        if(count($vehicle_type) > 0){
            foreach ($vehicle_type as $vt) {
                $vehicles =  DB::table('vehicles')
                ->where('vehicle_types_id', '=', $vt->id)
                ->get();
                foreach($vehicles as $vh)
                {
                    $schedules = DB::table('delivery_receipt_headers')
                    ->where('plateNumber', '=', $vh->plateNumber)
                    ->get();
                }
                $new_row['vehicle_type']['deliveries'] = 
                $new_row['vehicle_type'] = $vt;
                $new_row['vehicles'] = $vehicles;
                array_push($vehicle_type_with_vehicles, $new_row);

            }
        }
        return view('trucking.trucking_service_order_view_truck_schedule', compact(['vehicle_type_with_vehicles']));
    }

    public function getTruckSchedule(Request $request){
        $deliveries = DB::table('delivery_receipt_headers')
        ->where('plateNumber', '=', $request->plateNumber)
        ->get();
        return $deliveries;
    }

    public function get_area_rate(Request $request){
        $quotation = DB::table('quotation_details')
        ->join('quotation_headers as A', 'quotation_details.quot_header_id', '=', 'A.id')
        ->join('consignees AS B', 'A.consignees_id', '=', 'B.id')
        ->join('locations AS C', 'quotation_details.locations_id_from', '=', 'C.id')
        ->join('locations AS D', 'quotation_details.locations_id_to', '=', 'D.id')
        ->join('container_types AS E', 'quotation_details.container_volume', '=','E.id')
        ->select('C.name as from', 'D.name as to', 'E.name as volume', 'amount')
        ->where('B.id' ,'=', $request->consignee_id)
        ->where('quotation_details.locations_id_from', '=', $request->area_from)
        ->where('quotation_details.locations_id_to', '=', $request->area_to)
        ->get();
        
        $location = DB::table('standard_area_rates')
        ->where('areaFrom', '=', $request->area_from)
        ->where('areaTo', '=', $request->area_to)
        ->get();
        
        return Response::make(array($quotation , $location));
    }
    public function reschedule_delivery(Request $request){
        $delivery = \App\DeliveryReceiptHeader::findOrFail($request->delivery_id);
        $delivery->status = "C";
        $delivery->save();

        $new_delivery = new \App\DeliveryReceiptHeader;
        $new_delivery->emp_id_driver = $delivery->emp_id_driver;
        $new_delivery->emp_id_helper = $delivery->emp_id_helper;
        $new_delivery->locations_id_pick = $delivery->locations_id_pick;
        $new_delivery->locations_id_del = $delivery->locations_id_del;
        $new_delivery->plateNumber = $delivery->plateNumber;
        $new_delivery->withContainer = $delivery->withContainer;
        $new_delivery->status = "P";
        $new_delivery->amount = $delivery->amount;
        $new_delivery->deliveryDateTime = $request->deliveryDateTime;
        $new_delivery->pickupDateTime = $request->pickupDateTime;
        $new_delivery->tr_so_id = $delivery->tr_so_id;
        $new_delivery->save();

        if($delivery->withContainer == 0)
        {
            $delivery_non_containers = DB::table('delivery_head_non_containers')
            ->where('del_head_id', '=', $delivery->id)
            ->get();


            foreach ($delivery_non_containers as $key => $detail) 
            {
                $new_delivery_head_non_con = new \App\DeliveryHeadNonContainer;
                $new_delivery_head_non_con->del_head_id = $new_delivery->id;
                $new_delivery_head_non_con->non_con_id = $detail->non_con_id;

                $new_delivery_head_non_con->save();
            }

        }
        else
        {
            $delivery_containers = DB::table('delivery_head_containers')
            ->where('del_head_id', '=', $delivery->id)
            ->get();


            foreach ($delivery_containers as $key => $detail) 
            {
                $new_delivery_head_con = new \App\DeliveryHeadContainer;
                $new_delivery_head_con->del_head_id = $new_delivery->id;
                $new_delivery_head_con->container_id = $detail->container_id;

                $new_delivery_head_con->save();
            }
        }
        return $new_delivery;
    }

    public function edit_delivery(Request $request)
    {
        $so_id = $request->trucking_id;
        $delivery_details = [];

        $delivery = DB::table('delivery_receipt_headers')
        ->join('vehicles AS B', 'delivery_receipt_headers.plateNumber', '=', 'B.plateNumber')
        ->join('employees AS C', 'delivery_receipt_headers.emp_id_driver', '=', 'C.id')
        ->leftJoin('employees AS D', 'delivery_receipt_headers.emp_id_helper', '=', 'D.id')
        ->join('locations AS E', 'delivery_receipt_headers.locations_id_pick', '=','E.id')
        ->join('location_cities AS F', 'E.cities_id', '=','F.id')
        ->join('location_provinces AS G', 'F.provinces_id', '=','G.id')
        ->join('locations AS H', 'delivery_receipt_headers.locations_id_del', '=','H.id')
        ->join('location_cities AS I', 'H.cities_id', '=', 'I.id')
        ->join('location_provinces AS J', 'I.provinces_id', '=', 'J.id')
        ->join('vehicle_types AS K', 'B.vehicle_types_id', '=', 'K.id')
        ->where('delivery_receipt_headers.id', '=', $request->delivery_id)
        ->select(
            'delivery_receipt_headers.id',
            'delivery_receipt_headers.plateNumber',
            'delivery_receipt_headers.status',
            DB::raw('CONCAT(C.firstName, ", ", C.lastName) AS driverName'),
            DB::raw('CONCAT(D.firstName, ", ", D.lastName) AS helperName'),
            'delivery_receipt_headers.withContainer',
            'E.address as pick_up_address',
            'F.name as pick_up_city',
            'G.name as pick_up_province',
            'H.address as del_address',
            'I.name as del_city',
            'J.name as del_province',
            'delivery_receipt_headers.deliveryDateTime',
            'delivery_receipt_headers.pickupDateTime',
            'delivery_receipt_headers.remarks',
            'B.vehicle_types_id as vehicle_types_id',
            'delivery_receipt_headers.plateNumber',
            'delivery_receipt_headers.emp_id_driver',
            'delivery_receipt_headers.emp_id_helper',
            'delivery_receipt_headers.locations_id_del',
            'delivery_receipt_headers.locations_id_pick',
            'delivery_receipt_headers.withContainer',
            'delivery_receipt_headers.amount'
        )
        ->get();

        if($delivery[0]->withContainer == 0){
            $delivery_details = DB::table('delivery_non_container_details')
            ->join('delivery_head_non_containers as B', 'B.non_con_id', '=', 'delivery_non_container_details.id')
            ->join('delivery_receipt_headers as A', 'B.del_head_id', 'A.id')
            ->select('descriptionOfGoods', 'grossWeight', 'supplier', 'delivery_non_container_details.id', 'delivery_non_container_details.deleted_at')
            ->where('B.del_head_id', '=', $request->delivery_id)    
            ->get();
        }


        else{
            $container_with_detail = [];
            $delivery_containers = DB::table('delivery_containers')
            ->join('delivery_head_containers AS B', 'B.container_id', '=', 'delivery_containers.id')
            ->join('delivery_receipt_headers AS A', 'B.del_head_id', 'A.id')
            ->where('del_head_id', '=', $request->delivery_id)
            ->select('delivery_containers.id', 'containerNumber', 'containerVolume', 'containerReturnTo', 'containerReturnAddress', 'containerReturnDate', 'containerReturnStatus', 'dateReturned', 'delivery_containers.remarks', 'del_head_id', 'shippingLine', 'portOfCfsLocation')
            ->get();
            foreach ($delivery_containers as $container) {
                $container_details =  DB::table('delivery_container_details')
                ->select('delivery_container_details.id', 'descriptionOfGoods', 'grossWeight', 'supplier')
                ->where('container_id', '=', $container->id)
                ->get();

                $new_row['container'] = $container;
                $new_row['details'] = $container_details;
                array_push($container_with_detail, $new_row);

            }

        }

        $consignee = DB::table('consignees')
        ->select('consignees.id')
        ->join('consignee_service_order_headers as A', 'A.consignees_id', '=', 'consignees.id')
        ->join('consignee_service_order_details as B', 'B.so_headers_id', '=', 'A.id')
        ->join('trucking_service_orders as C', 'C.so_details_id', '=', 'B.id')
        ->get();


        $container_volumes = ContainerType::all();
        $vehicle_types = VehicleType::all();
        $employees = Employee::all();

        $locations = \App\Location::all();

        $provinces = \App\LocationProvince::all();

        $delivery_order = TruckingServiceOrder::findOrFail($so_id);


        if($delivery[0]->status == 'P')
        {
            return view('trucking.delivery_edit', compact(['container_volumes', 'vehicle_types', 'employees', 'so_id', 'locations', 'provinces', 'delivery', 'delivery_details', 'delivery_containers', 'so_id', 'container_with_detail', 'consignee']));
        }
        else{
            return 'Cannot edit finished/cancelled deliveries';
        }
    }

    public function create_tr_billing_header(Request $request){
        $consignee_order = \DB::table('consignee_service_order_headers')
        ->join('consignee_service_order_details AS A', 'A.so_headers_id', '=', 'consignee_service_order_headers.id')
        ->join('trucking_service_orders AS B', 'B.so_details_id', '=', 'A.id')
        ->select('consignee_service_order_headers.id')
        ->where('B.id', '=', $request->tr_so_id)
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

        $consignee_header = \App\TruckingServiceOrder::findOrFail($request->tr_so_id);
        switch ($request->isRevenue) {
            case 0:
            $consignee_header->bi_head_id_exp = $billing_header->id;
            break;

            case 1:
            $consignee_header->bi_head_id_rev = $billing_header->id;
            break;

            default:
                # code...
            break;
        }
        $consignee_header->save();

        return $consignee_header;

    }
    public function view_trucking(Request $request){
        try
        {
            $bill_revs = DB::table('charges')
            ->select('id','name', 'amount')
            ->where('bill_type', '=', 'R')
            ->get();

            $bill_exps = DB::table('charges')
            ->select('id','name', 'amount')
            ->where('bill_type', '=', 'E')
            ->get();

            $so_id = $request->trucking_id;
            $service_order = TruckingServiceOrder::findOrFail($so_id);
            $service_order_details = DB::table('trucking_service_orders')
            ->join('consignee_service_order_details', 'so_details_id', '=', 'consignee_service_order_details.id')
            ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
            ->join('consignees', 'consignees_id', '=', 'consignees.id')
            ->select('firstName', 'middleName', 'lastName', 'companyName', 'consignees.id')
            ->where('trucking_service_orders.id', '=', $so_id)
            ->get();

            $employees = Employee::all();

            $vehicle_types = VehicleType::all();

            $container_volumes = ContainerType::all();

            $vehicles = DB::table('vehicles')
            ->join('vehicle_types', 'vehicle_types_id', '=', 'vehicle_types.id')
            ->select('plateNumber', 'name', 'model')
            ->where('vehicles.deleted_at', '=', null)
            ->get();

            $deliveries = DB::table('delivery_receipt_headers')
            ->select('id', 'plateNumber', 'created_at', 'status', 'amount')
            ->where('deleted_at', '=', null)
            ->where('tr_so_id','=', $so_id)
            ->get();

            $estimate = 0;

            foreach ($deliveries as $delivery => $delivery_value) {
                $estimate += $delivery_value->amount;
            }

            $success_trucking = DB::table('delivery_receipt_headers')
            ->select('id')
            ->where('tr_so_id', '=', $so_id)
            ->where('status', '=', 'F')
            ->count();

            $cancelled_trucking = DB::table('delivery_receipt_headers')
            ->select('id')
            ->where('tr_so_id', '=', $so_id)
            ->where('status', '=', 'C')
            ->count();

            $pending_trucking = DB::table('delivery_receipt_headers')
            ->select('id')
            ->where('tr_so_id', '=', $so_id)
            ->where('status', '=', 'P')
            ->count();

            $deposits = DB::table('consignee_deposits')
            ->where('consignees_id', '=', $service_order_details[0]->id)
            ->where('currentBalance', '>', 0)
            ->get();

            return view('trucking/trucking_service_order_view', compact(['so_id', 'service_order', 'employees', 'vehicles', 'deliveries', 'success_trucking', 'cancelled_trucking', 'pending_trucking', 'vehicle_types', 'container_volumes', 'service_order_details', 'bill_revs', 'bill_exps', 'estimate', 'deposits']));   
        }
        catch(ModelNotFoundException $e)
        {
            return 'No service order';
        }
    }

    public function new_delivery(Request $request)
    {
        $so_id = $request->trucking_id;
        $container_volumes = ContainerType::all();
        $vehicle_types = VehicleType::all();
        $employees = Employee::all();

        $locations = \App\Location::all();

        $provinces = \App\LocationProvince::all();

        $delivery = TruckingServiceOrder::findOrFail($so_id);

        $consignee = DB::table('consignees')
        ->select('consignees.id')
        ->join('consignee_service_order_headers as A', 'A.consignees_id', '=', 'consignees.id')
        ->join('consignee_service_order_details as B', 'B.so_headers_id', '=', 'A.id')
        ->join('trucking_service_orders as C', 'C.so_details_id', '=', 'B.id')
        ->get();

        if($delivery->status == 'P')
        {
            return view('trucking.delivery_create', compact(['container_volumes', 'vehicle_types', 'employees', 'so_id', 'locations', 'provinces', 'consignee']));
        }
        else{
            return 'Cannot create new deliveries';
        }

    }

    public function store_delivery(Request $request)
    {
        if($request->containerNumber == null)
        {
            $new_delivery_head = new DeliveryReceiptHeader;
            $new_delivery_head->emp_id_driver = $request->emp_id_driver;
            if($request->emp_id_helper == 0){
             $new_delivery_head->emp_id_helper = null;
         }
         else{
            $new_delivery_head->emp_id_helper = $request->emp_id_helper;    
        }
        $new_delivery_head->locations_id_pick = $request->locations_id_pick;
        $new_delivery_head->locations_id_del = $request->locations_id_del;

        $new_delivery_head->plateNumber = $request->plateNumber;
        $new_delivery_head->status = "P";
        $new_delivery_head->withContainer = 0;
        $new_delivery_head->deliveryDateTime = $request->deliveryDate;
        $new_delivery_head->pickupDateTime = $request->pickupDate;
        $new_delivery_head->tr_so_id = $request->trucking_id;
        $new_delivery_head->amount = $request->amount;

        $new_delivery_head->save();

        for($i = 0; $i < count($request->descrp_goods); $i++)
        {
            $new_noncon_detail = new DeliveryNonContainerDetail;
            $new_noncon_detail->descriptionOfGoods = $request->descrp_goods[$i];
            $new_noncon_detail->grossWeight = $request->gross_weights[$i];
            $new_noncon_detail->supplier = $request->suppliers[$i];

            $new_noncon_detail->save();

            $new_del_non_head = new \App\DeliveryHeadNonContainer;
            $new_del_non_head->del_head_id = $new_delivery_head->id;
            $new_del_non_head->non_con_id = $new_noncon_detail->id;
            $new_del_non_head->save();
        }

    }
    else
    {
        $response = ""; 
        $new_delivery_head = new DeliveryReceiptHeader;
        $new_delivery_head->emp_id_driver = $request->emp_id_driver;
        $new_delivery_head->emp_id_helper = $request->emp_id_helper;

        $new_delivery_head->locations_id_pick = $request->locations_id_pick;
        $new_delivery_head->locations_id_del = $request->locations_id_del;

        $new_delivery_head->deliveryDateTime = $request->deliveryDate;
        $new_delivery_head->pickupDateTime = $request->pickupDate;

        $new_delivery_head->plateNumber = $request->plateNumber;
        $new_delivery_head->status = "P";
        $new_delivery_head->withContainer = 1;
        $new_delivery_head->tr_so_id = $request->trucking_id;

        $new_delivery_head->amount = $request->amount;

        $new_delivery_head->save();

        $data = json_decode($request->container_data);
        foreach ($data as $container => $value)
        {
            $container = json_decode((string)json_encode($value));
            foreach ($container as $key => $container_detail)
            {
                $new_delivery_container = new DeliveryContainer;

                $new_delivery_container->containerNumber = $container_detail->container[0]->containerNumber;
                $new_delivery_container->containerVolume = $container_detail->container[0]->containerVolume;
                $new_delivery_container->shippingLine = $container_detail->container[0]->shippingLine;
                $new_delivery_container->portOfCfsLocation = $container_detail->container[0]->portOfCfsLocation;
                $new_delivery_container->containerReturnTo = $container_detail->container[0]->containerReturnTo;
                $new_delivery_container->containerReturnAddress = $container_detail->container[0]->containerReturnAddress;
                $new_delivery_container->containerReturnDate = $container_detail->container[0]->containerReturnDate;
                $new_delivery_container->containerReturnStatus = "N";
                $new_delivery_container->dateReturned = null;
                $new_delivery_container->remarks = "";


                $new_delivery_container->save();

                $new_del_head_con = new \App\DeliveryHeadContainer;
                $new_del_head_con->del_head_id = $new_delivery_head->id;
                $new_del_head_con->container_id = $new_delivery_container->id;

                $new_del_head_con->save();


                foreach ($container_detail->details as $key => $container_detail_data)
                {

                    $new_delivery_container_detail = new DeliveryContainerDetail;
                    $new_delivery_container_detail->descriptionOfGoods = $container_detail_data->descriptionOfGood;
                    $new_delivery_container_detail->grossWeight = $container_detail_data->grossWeight;
                    $new_delivery_container_detail->supplier = $container_detail_data->supplier;
                    $new_delivery_container_detail->container_id = $new_delivery_container->id;

                    $new_delivery_container_detail->save();
                    $response .= $container_detail_data->descriptionOfGood;
                }

            }
        }
        return $response;
    }
}
public function update_delivery(Request $request){
    $delivery = DeliveryReceiptHeader::findOrFail($request->delivery_head_id);
    $delivery->status = $request->status;
    $delivery->remarks = $request->remarks;
    $delivery->cancelDateTime = $request->cancelDateTime;
    $delivery->save();
    return $delivery;
}

public function getVehicles(Request $request){
    $vehicles = DB::table('vehicles')
    ->where('deleted_at', '=', null)
    ->where('vehicle_types_id', '=', $request->vehicle_type)
    ->get();

    return $vehicles;
}

public function getContainerDetail(Request $request){
    $container_information = DB::table('delivery_containers')
    ->where('id', '=', $request->container_id)
    ->select('delivery_containers.id', 'containerNumber', 'containerVolume', 'containerReturnStatus')
    ->get();

    $container_details =  DB::table('delivery_container_details')
    ->select('delivery_container_details.id', 'descriptionOfGoods', 'grossWeight', 'supplier')
    ->where('container_id', '=', $request->container_id)
    ->get();

    return Response::make(array($container_details, $container_information));;
}

public function update_delivery_record(Request $request)
{
    if($request->withContainer == "0"){

        $delivery = \App\DeliveryReceiptHeader::findOrFail($request->del_head_id);
        $delivery->emp_id_driver = $request->emp_id_driver;
        $delivery->emp_id_helper = $request->emp_id_helper;

        $delivery->locations_id_pick = $request->locations_id_pick;
        $delivery->locations_id_del = $request->locations_id_del;

        $delivery->deliveryDateTime = $request->deliveryDate;
        $delivery->pickupDateTime = $request->pickupDate;

        $delivery->plateNumber = $request->plateNumber;
        $delivery->amount = $request->amount;

        $delivery->save();

        $json_record = json_decode($request->delivery_non_container_array);

        for($i = 0; $i < count($json_record); $i++)
        {
            $edit_non_con_detail = \App\DeliveryNonContainerDetail::withTrashed()->findOrFail($json_record[$i]->id);
            $edit_non_con_detail->descriptionOfGoods = $json_record[$i]->descriptionOfGood;
            $edit_non_con_detail->grossWeight = $json_record[$i]->grossWeight;
            $edit_non_con_detail->supplier = $json_record[$i]->supplier;

            $edit_non_con_detail->save();

            if($json_record[$i]->status != "1")
            {
                $deactivate_record = \App\DeliveryNonContainerDetail::withTrashed()->findOrFail($json_record[$i]->id);
                $deactivate_record->delete();
            }
            else
            {
                $reactivate_record = \App\DeliveryNonContainerDetail::withTrashed()->findOrFail($json_record[$i]->id);
                $reactivate_record->restore();
            }
        }
        $new_json_record = json_decode($request->delivery_non_container_new_array);
        for($i = 0; $i < count($new_json_record); $i++)
        {
            $new_non_con_detail = new \App\DeliveryNonContainerDetail;
            $new_non_con_detail->descriptionOfGoods = $new_json_record[$i]->descriptionOfGoods;
            $new_non_con_detail->grossWeight = $new_json_record[$i]->grossWeight;
            $new_non_con_detail->supplier = $new_json_record[$i]->supplier;

            $new_non_con_detail->save();

            $new_del_non_head = new \App\DeliveryHeadNonContainer;
            $new_del_non_head->del_head_id = $delivery->id;
            $new_del_non_head->non_con_id = $new_non_con_detail->id;
            $new_del_non_head->save();
        }

        return $delivery;
    }
    else
    {
        $response = "";
        $containers = \DB::table('delivery_containers')
        ->where('del_head_id', '=', $request->del_head_id)
        ->get();


        for($i = 0; $i< count($containers); $i++){
            \DB::table('delivery_container_details')
            ->where('container_id', '=', $containers[$i]->id)
            ->delete();

            \DB::table('delivery_containers')
            ->where('id', '=', $containers[$i]->id)
            ->delete();
        }

        $delivery = \App\DeliveryReceiptHeader::findOrFail($request->del_head_id);
        $delivery->emp_id_driver = $request->emp_id_driver;
        $delivery->emp_id_helper = $request->emp_id_helper;

        $delivery->locations_id_pick = $request->locations_id_pick;
        $delivery->locations_id_del = $request->locations_id_del;

        $delivery->deliveryDateTime = $request->deliveryDate;
        $delivery->pickupDateTime = $request->pickupDate;

        $delivery->plateNumber = $request->plateNumber;
        $delivery->amount = $request->amount;

        $delivery->save();

        $data = json_decode($request->container_data);
        foreach ($data as $container => $value)
        {
            $container = json_decode((string)json_encode($value));
            foreach ($container as $key => $container_detail)
            {
                $new_delivery_container = new DeliveryContainer;

                $new_delivery_container->containerNumber = $container_detail->container[0]->containerNumber;
                $new_delivery_container->containerVolume = $container_detail->container[0]->containerVolume;
                $new_delivery_container->shippingLine = $container_detail->container[0]->shippingLine;
                $new_delivery_container->portOfCfsLocation = $container_detail->container[0]->portOfCfsLocation;
                $new_delivery_container->containerReturnTo = $container_detail->container[0]->containerReturnTo;
                $new_delivery_container->containerReturnAddress = $container_detail->container[0]->containerReturnAddress;
                $new_delivery_container->containerReturnDate = $container_detail->container[0]->containerReturnDate;
                $new_delivery_container->containerReturnStatus = "N";
                $new_delivery_container->dateReturned = null;
                $new_delivery_container->remarks = "";
                $new_delivery_container->del_head_id = $request->del_head_id;

                $new_delivery_container->save();


                foreach ($container_detail->details as $key => $container_detail_data){

                    $new_delivery_container_detail = new DeliveryContainerDetail;
                    $new_delivery_container_detail->descriptionOfGoods = $container_detail_data->descriptionOfGood;
                    $new_delivery_container_detail->grossWeight = $container_detail_data->grossWeight;
                    $new_delivery_container_detail->supplier = $container_detail_data->supplier;
                    $new_delivery_container_detail->container_id = $new_delivery_container->id;

                    $new_delivery_container_detail->save();
                    $response .= $container_detail_data->descriptionOfGood;
                }

            }
        }

    }

}

public function view_delivery(Request $request){
    $so_id = $request->trucking_id;

    $delivery = DB::table('delivery_receipt_headers')
    ->join('vehicles AS B', 'delivery_receipt_headers.plateNumber', '=', 'B.plateNumber')
    ->join('employees AS C', 'delivery_receipt_headers.emp_id_driver', '=', 'C.id')
    ->leftJoin('employees AS D', 'delivery_receipt_headers.emp_id_helper', '=', 'D.id')
    ->join('locations AS E', 'delivery_receipt_headers.locations_id_pick', '=','E.id')
    ->join('location_cities AS F', 'E.cities_id', '=','F.id')
    ->join('location_provinces AS G', 'F.provinces_id', '=','G.id')
    ->join('locations AS H', 'delivery_receipt_headers.locations_id_del', '=','H.id')
    ->join('location_cities AS I', 'H.cities_id', '=', 'I.id')
    ->join('location_provinces AS J', 'I.provinces_id', '=', 'J.id')
    ->join('vehicle_types AS K', 'B.vehicle_types_id', '=', 'K.id')
    ->where('delivery_receipt_headers.id', '=', $request->delivery_id)
    ->select(
        'delivery_receipt_headers.id',
        'delivery_receipt_headers.plateNumber',
        'delivery_receipt_headers.status',
        DB::raw('CONCAT(C.firstName, ", ", C.lastName) AS driverName'),
        DB::raw('CONCAT(D.firstName, ", ", D.lastName) AS helperName'),
        'delivery_receipt_headers.withContainer',
        'E.address as pick_up_address',
        'F.name as pick_up_city',
        'G.name as pick_up_province',
        'H.address as del_address',
        'I.name as del_city',
        'J.name as del_province',
        'delivery_receipt_headers.deliveryDateTime',
        'delivery_receipt_headers.pickupDateTime',
        'delivery_receipt_headers.cancelDateTime',
        'delivery_receipt_headers.remarks',
        'delivery_receipt_headers.emp_id_helper',
        DB::raw('CONCAT(delivery_receipt_headers.plateNumber, " - ", K.name) as plateNumber')
    )

    ->get();

    if($delivery[0]->withContainer == 0){
        $delivery_details = DB::table('delivery_non_container_details')
        ->join('delivery_head_non_containers as B', 'B.non_con_id', '=', 'delivery_non_container_details.id')
        ->join('delivery_receipt_headers as A', 'B.del_head_id', 'A.id')
        ->select('descriptionOfGoods', 'grossWeight', 'supplier')
        ->where('B.del_head_id', '=', $delivery[0]->id)
        ->where('delivery_non_container_details.deleted_at', '=', null)
        ->get();
    }
    else{
        $container_with_detail = [];
        $delivery_containers = DB::table('delivery_containers')
        ->join('delivery_head_containers AS B', 'B.container_id', '=', 'delivery_containers.id')
        ->join('delivery_receipt_headers AS A', 'B.del_head_id', 'A.id')
        ->where('B.del_head_id', '=', $delivery[0]->id)
        ->select('delivery_containers.id', 'containerNumber', 'containerVolume', 'containerReturnTo', 'containerReturnAddress', 'containerReturnDate', 'containerReturnStatus', 'dateReturned', 'delivery_containers.remarks', 'del_head_id', 'shippingLine', 'portOfCfsLocation')
        ->get();
        foreach ($delivery_containers as $container) {
            $container_details =  DB::table('delivery_container_details')
            ->select('delivery_container_details.id', 'descriptionOfGoods', 'grossWeight', 'supplier')
            ->where('container_id', '=', $container->id)
            ->get();

            $new_row['container'] = $container;
            $new_row['details'] = $container_details;
            array_push($container_with_detail, $new_row);
        }

    }
        //return $container_with_detail;
    return view('trucking.delivery_view', compact(['delivery', 'delivery_details', 'delivery_containers', 'so_id', 'container_with_detail']));
}

public function update_container(Request $request){
    $container = DeliveryContainer::findOrFail($request->containerID);
    if($container->dateReturned != null)
    {
        $container->remarks = $request->remarks;
        $container->save();
    }
    else
    {
        $container->dateReturned = $request->dateReturned;
        $container->containerReturnStatus = $request->status;
        $container->remarks = $request->remarks;
        $container->save();

    }
    return $container;
}

public function update_delivery_bill(Request $request){
    $delivery_receipt = DeliveryReceiptHeader::findOrFail($request->delivery_id);
    $delivery_receipt->amount = $request->amount;

    $delivery_receipt->save();

    return $delivery_receipt;
}

public function bill_delivery(Request $request){
    $so_id = $request->trucking_id;

    $charges = Charge::all();

    $consignee = DB::table('consignees')
    ->join('consignee_service_order_headers AS A', 'consignees.id', '=' , 'A.consignees_id')
    ->join('consignee_service_order_details AS B', 'B.so_headers_id', '=', 'A.id')
    ->join('trucking_service_orders AS C', 'C.so_details_id', '=', 'B.id')
    ->join('delivery_receipt_headers AS D', 'D.tr_so_id', '=', 'C.id')
    ->select('consignees.id','firstName', 'middleName', 'lastName', 'companyName')
    ->where('D.id', '=', $request->delivery_id)
    ->get();

    $delivery = DB::table('delivery_receipt_headers')
    ->join('vehicles AS B', 'delivery_receipt_headers.plateNumber', '=', 'B.plateNumber')
    ->join('employees AS C', 'delivery_receipt_headers.emp_id_driver', '=', 'C.id')
    ->join('employees AS D', 'delivery_receipt_headers.emp_id_helper', '=', 'D.id')
    ->where('delivery_receipt_headers.id', '=', $request->delivery_id)
    ->select(
        'delivery_receipt_headers.amount',
        'delivery_receipt_headers.id',
        'delivery_receipt_headers.plateNumber',
        'delivery_receipt_headers.status',
        DB::raw('CONCAT(C.firstName, ", ", C.lastName) AS driverName'),
        DB::raw('CONCAT(D.firstName, ", ", D.lastName) AS helperName'),
        'delivery_receipt_headers.withContainer'
    )

    ->get();

    $delivery_bills = DB::table('delivery_billings')
    ->join('charges', 'charges_id', '=', 'charges.id')
    ->orderBy('isBilledTo')
    ->select('charges.name AS charge_description', 'charges_id', 'amount', 'isBilled', 'isBilledTo', 'remarks')
    ->where('del_head_id', '=',  $delivery[0]->id)
    ->get();

    $total_penalty_consignee = 0;
    $total_penalty_client = 0;

    for($i = 0; $i <count($delivery_bills); $i++) 
    {
        if($delivery_bills[$i]->isBilledTo == 0){
            $total_penalty_consignee += $delivery_bills[$i]->amount;
        }
        else{
            $total_penalty_client += $delivery_bills[$i]->amount;
        }
    }
    $total_penalty_consignee = number_format((float)$total_penalty_consignee, 2, '.', '');
    $total_penalty_client = number_format((float)$total_penalty_client, 2, '.', '');

    if($delivery[0]->withContainer == 0){
        $delivery_details = DB::table('delivery_non_container_details')
        ->join('delivery_receipt_headers', 'del_head_id', 'delivery_receipt_headers.id')
        ->select('descriptionOfGoods', 'grossWeight', 'supplier')
        ->where('del_head_id', '=', $delivery[0]->id)
        ->get();
    }
    else{
        $container_with_detail = [];
        $delivery_containers = DB::table('delivery_containers')
        ->join('delivery_receipt_headers AS A', 'del_head_id', 'A.id')
        ->where('del_head_id', '=', $delivery[0]->id)
        ->select('delivery_containers.id', 'containerNumber', 'containerVolume', 'containerReturnTo', 'containerReturnAddress', 'containerReturnDate', 'containerReturnStatus', 'dateReturned', 'delivery_containers.remarks', 'del_head_id')
        ->get();
        foreach ($delivery_containers as $container) {
            $container_details =  DB::table('delivery_container_details')
            ->select('delivery_container_details.id', 'descriptionOfGoods', 'grossWeight', 'supplier')
            ->where('container_id', '=', $container->id)
            ->get();

            $new_row['container'] = $container;
            $new_row['details'] = $container_details;
            array_push($container_with_detail, $new_row);
        }

    }

    return view('trucking.delivery_bill', compact(['delivery', 'delivery_details', 'delivery_containers', 'so_id', 'container_with_detail', 'consignee', 'charges', 'delivery_bills', 'total_penalty_consignee', 'total_penalty_client']));
}

public function get_contract_details(Request $request){
    $contract = DB::table('contract_headers')
    ->select('dateEffective', 'dateExpiration', 'specificDetails')
    ->where('contract_headers.id', '=', $request->contract_id)
    ->get();
    $contract_details = DB::table('contract_details')
    ->select('A.description AS from', 'B.description AS to', 'amount')
    ->join('areas AS A', 'areas_id_from', '=', 'A.id')
    ->join('areas AS B', 'areas_id_to', '=', 'B.id')
    ->where('contract_headers_id', '=', $request->contract_id)
    ->get();

    return Response::make(array($contract, $contract_details));
}

public function store_delivery_bill(Request $request){

    $delivery_bill = new DeliveryBilling;
    $delivery_bill->charges_id = $request->charges_id;
    $delivery_bill->amount = $request->amount;
    $delivery_bill->isBilled = $request->isBilled;
    $delivery_bill->isBilledTo = $request->isBilledTo;
    $delivery_bill->remarks = $request->remarks;
    $delivery_bill->del_head_id = $request->del_head_id;

    $delivery_bill->save();

    return $delivery_bill;
}

public function create_pdf(){
    $data = Vehicle::all();
    $pdf = PDF::loadView('reports/pdfview', compact(['data']));
    return $pdf->stream();
}

public function delivery_pdf(Request $request){
    $so_id = $request->trucking_id;

    $delivery = DB::table('delivery_receipt_headers')
    ->join('vehicles AS B', 'delivery_receipt_headers.plateNumber', '=', 'B.plateNumber')
    ->join('employees AS C', 'delivery_receipt_headers.emp_id_driver', '=', 'C.id')
    ->leftJoin('employees AS D', 'delivery_receipt_headers.emp_id_helper', '=', 'D.id')
    ->join('trucking_service_orders AS E', 'delivery_receipt_headers.tr_so_id', '=', 'E.id')
    ->join('consignee_service_order_details AS F', 'E.so_details_id', '=', 'F.id')
    ->join('consignee_service_order_headers AS G', 'F.so_headers_id', '=','G.id')
    ->join('consignees AS H', 'G.consignees_id', '=', 'H.id')
    ->join('locations AS I', 'locations_id_del', 'I.id')
    ->join('locations AS J', 'locations_id_pick', 'J.id')
    ->where('delivery_receipt_headers.id', '=', $request->delivery_id)
    ->select(
        'delivery_receipt_headers.id',
        'delivery_receipt_headers.plateNumber',
        'delivery_receipt_headers.status',
        DB::raw('CONCAT(C.firstName, " ", C.lastName) AS driverName'),
        DB::raw('CONCAT(D.firstName, " ", D.lastName) AS helperName'),
        'delivery_receipt_headers.withContainer',
        'J.address as deliveryAddress',
        'H.companyName',
        'delivery_receipt_headers.deliveryDateTime'
    )
    ->get();

    if($delivery[0]->withContainer == 0){
        $delivery_details = DB::table('delivery_non_container_details')
        ->join('delivery_head_non_containers AS B', 'B.non_con_id', '=', 'delivery_non_container_details.id')
        ->join('delivery_receipt_headers AS A', 'B.del_head_id', 'A.id')
        ->select('descriptionOfGoods', 'grossWeight', 'supplier')
        ->where('del_head_id', '=', $delivery[0]->id)
        ->where('delivery_non_container_details.deleted_at', '=', null)
        ->get();
    }
    else{
        $container_with_detail = [];
        $delivery_containers = DB::table('delivery_containers')
        ->join('delivery_head_containers AS B', 'B.container_id', '=', 'delivery_containers.id')
        ->join('delivery_receipt_headers AS A', 'B.del_head_id', 'A.id')
        ->where('B.del_head_id', '=', $delivery[0]->id)
        ->select('delivery_containers.id', 'containerNumber', 'containerVolume', 'containerReturnTo', 'containerReturnAddress', 'containerReturnDate', 'containerReturnStatus', 'dateReturned', 'delivery_containers.remarks', 'del_head_id')
        ->get();
        foreach ($delivery_containers as $container) {
            $container_details =  DB::table('delivery_container_details')
            ->select('delivery_container_details.id', 'descriptionOfGoods', 'grossWeight', 'supplier')
            ->where('container_id', '=', $container->id)
            ->get();

            $new_row['container'] = $container;
            $new_row['details'] = $container_details;
            array_push($container_with_detail, $new_row);
        }

    }

    $pdf = PDF::loadView('pdf_layouts.delivery_receipt_pdf', compact(['delivery', 'delivery_details', 'delivery_containers', 'so_id', 'container_with_detail']));
    return $pdf->stream();
}


public function show_calendar(){
    $deliveries = DB::table('delivery_receipt_headers')
    ->select('deliveryDateTime', 'pickupDateTime', 'trucking_service_orders.id as tr_so_id', 'plateNumber', 'delivery_receipt_headers.id as del_head_id')
    ->join('trucking_service_orders', 'delivery_receipt_headers.tr_so_id', '=', 'trucking_service_orders.id')
    ->whereRaw('delivery_receipt_headers.status IN("P", "F")')
    ->get();

    return view('pdf_layouts.calendar', compact(['deliveries']));
}
}