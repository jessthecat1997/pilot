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
        return view('trucking.trucking_service_order_index');
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
        $new_so_head->paymentStatus = "U";
        $new_so_head->save();


        $new_so_detail = new ConsigneeServiceOrderDetail;
        $new_so_detail->so_headers_id = $new_so_head->id;
        $new_so_detail->service_order_types_id = 2;
        $new_so_detail->save();

        $new_trucking  = new TruckingServiceOrder;
        $new_trucking->status = "P";
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

    public function view_trucking(Request $request){
        try
        {
            $so_id = $request->trucking_id;
            $service_order = TruckingServiceOrder::findOrFail($so_id);
            $service_order_details = DB::table('trucking_service_orders')
            ->join('consignee_service_order_details', 'so_details_id', '=', 'consignee_service_order_details.id')
            ->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
            ->join('consignees', 'consignees_id', '=', 'consignees.id')
            ->select('firstName', 'middleName', 'lastName', 'companyName')
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
            ->select('id', 'plateNumber', 'created_at', 'status')
            ->where('deleted_at', '=', null)
            ->where('tr_so_id','=', $so_id)
            ->get();

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



            return view('trucking/trucking_service_order_view', compact(['so_id', 'service_order', 'employees', 'vehicles', 'deliveries', 'success_trucking', 'cancelled_trucking', 'pending_trucking', 'vehicle_types', 'container_volumes', 'service_order_details']));   
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


        if($delivery->status == 'P')
        {
            return view('trucking.delivery_create', compact(['container_volumes', 'vehicle_types', 'employees', 'so_id', 'locations', 'provinces']));
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
            $new_delivery_head->emp_id_helper = $request->emp_id_helper;

            $new_delivery_head->locations_id_pick = $request->locations_id_pick;
            $new_delivery_head->locations_id_del = $request->locations_id_del;
          
            $new_delivery_head->plateNumber = $request->plateNumber;
            $new_delivery_head->status = "P";
            $new_delivery_head->withContainer = 0;
            $new_delivery_head->deliveryDateTime = $request->deliveryDate;
            $new_delivery_head->pickupDateTime = $request->pickupDate;
            $new_delivery_head->tr_so_id = $request->trucking_id;

            $new_delivery_head->save();

            for($i = 0; $i < count($request->descrp_goods); $i++)
            {
                $new_noncon_detail = new DeliveryNonContainerDetail;
                $new_noncon_detail->descriptionOfGoods = $request->descrp_goods[$i];
                $new_noncon_detail->grossWeight = $request->gross_weights[$i];
                $new_noncon_detail->supplier = $request->suppliers[$i];
                $new_noncon_detail->del_head_id =  $new_delivery_head->id;
                $new_noncon_detail->save();
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
                    $new_delivery_container->del_head_id = $new_delivery_head->id;

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
            return $response;
        }
    }
    public function update_delivery(Request $request){
        $delivery = DeliveryReceiptHeader::findOrFail($request->delivery_head_id);
        $delivery->status = $request->status;
        $delivery->save();
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

    public function view_delivery(Request $request){
        $so_id = $request->trucking_id;

        $delivery = DB::table('delivery_receipt_headers')
        ->join('vehicles AS B', 'delivery_receipt_headers.plateNumber', '=', 'B.plateNumber')
        ->join('employees AS C', 'delivery_receipt_headers.emp_id_driver', '=', 'C.id')
        ->join('employees AS D', 'delivery_receipt_headers.emp_id_helper', '=', 'D.id')
        ->where('delivery_receipt_headers.id', '=', $request->delivery_id)
        ->select(
            'delivery_receipt_headers.id',
            'delivery_receipt_headers.plateNumber',
            'delivery_receipt_headers.status',
            DB::raw('CONCAT(C.firstName, ", ", C.lastName) AS driverName'),
            DB::raw('CONCAT(D.firstName, ", ", D.lastName) AS helperName'),
            'delivery_receipt_headers.withContainer'
            )

        ->get();

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
        ->join('employees AS D', 'delivery_receipt_headers.emp_id_helper', '=', 'D.id')
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

        $pdf = PDF::loadView('pdf_layouts.delivery_receipt_pdf', compact(['delivery', 'delivery_details', 'delivery_containers', 'so_id', 'container_with_detail']));
        return $pdf->stream();
    }

   
    public function show_calendar(){
     $events = [];

     $events[] = \Calendar::event(
        'Event One', 
        false, 
        '2017-02-11T0800', 
        '2017-02-13T0800',
        0
        );
     $calendar = \Calendar::addEvents($events)
       ->setOptions([ //set fullcalendar options
        'firstDay' => 1
        ]); 
       return view('pdf_layouts.calendar', compact('calendar'));
   }
}
