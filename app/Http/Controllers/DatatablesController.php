<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\service_order_type;
use App\VehicleType;
use App\Charge;
use App\Brokerage_status_type;
use App\ContainerType;
use App\ExchangeRate;
use App\ReceiveType;
use App\EmployeeType;
use App\Consignee;
use App\Vehicle;
use App\Billing;
use App\Area;
use App\CdsFee;
use App\BrokerageFee;
use App\VatRate;
use App\LocationProvince;
use App\LocationCities;
use App\ContractTemplate;
use App\BillingInvoiceHeader;
use App\ConsigneeServiceOrderHeader;
use App\BrokerageServiceOrderDetails;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatatablesController extends Controller
{
	public function vt_datatable(){
		$vtypes = VehicleType::select(['id', 'name','description', 'withContainer', 'created_at']);
		return Datatables::of($vtypes)
		->addColumn('action', function ($vtype) {
			return
			'<button value = "'. $vtype->id .'" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $vtype->id .'" class="btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{$id}}')
		->make(true);
	}
	public function sot_datatable(){
		$sots = service_order_type::select(['id', 'name', 'description', 'created_at']);

		return Datatables::of($sots)
		->addColumn('action', function ($sot){
			return
			'<button value = "'. $sot->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $sot->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function ch_datatable(){
		$charges = Charge::select(['id', 'name', 'description','bill_type','chargeType','amount','created_at']);

		return Datatables::of($charges)
		->addColumn('action', function ($ch){
			return
			'<button value = "'. $ch->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $ch->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function bst_datatable(){
		$bst = Brokerage_status_type::select(['id', 'description', 'created_at']);

		return Datatables::of($bst)
		->addColumn('action', function ($bs){
			return
			'<button value = "'. $bs->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $bs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function ct_datatable(){
		$cts = ContainerType::select(['id', 'name','description','maxWeight', 'created_at']);

		return Datatables::of($cts)
		->addColumn('action', function ($ct){
			return
			'<button value = "'. $ct->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $ct->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function er_datatable(){
		$ers = ExchangeRate::select(['id', 'description', 'rate', 'dateEffective', 'created_at']);

		return Datatables::of($ers)
		->addColumn('action', function ($er){
			return
			'<button value = "'. $er->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $er->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('rate', 'Php {{ $rate }}')
		->make(true);
	}

	public function rt_datatable(){
		$rts = ReceiveType::select(['id', 'name', 'description', 'created_at']);

		return Datatables::of($rts)
		->addColumn('action', function ($rt){
			return
			'<button value = "'. $rt->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $rt->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function ctemp_datatable(){
		$ctemps = ContractTemplate::select(['id', 'name', 'description', 'created_at']);

		return Datatables::of($ctemps)
		->addColumn('action', function ($ctemp){
			return
			'<button value = "'. $ctemp->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $ctemp->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function et_datatable(){
		$ets = EmployeeType::select(['id', 'name', 'description', 'created_at']);

		return Datatables::of($ets)
		->addColumn('action', function ($et){
			return
			'<button value = "'. $et->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $et->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function consignee_datatable(){
		$consignees = consignee::select(['id', 'firstName', 'middleName','lastName','companyName', 'email', 'contactNumber','created_at']);

		return Datatables::of($consignees)

		->editColumn('firstName', '{{ $firstName . " " .$middleName . " ". $lastName }}')
		->removeColumn('middleName')
		->removeColumn('lastName')
		->addColumn('action', function ($consignee){
			return
			'<button value = "'. $consignee->id .'" class = "btn btn-md btn-primary selectConsignee ">Select</button>';
		})
		->editColumn('consigneeType', function($consignee){
			if( $consignee->consigneeType == 0){
				return 'Walk-in';
			}
			else{
				return 'Regular';
			}
		})
		->make(true);
	}

	public function consignee_datatable_main(){
		$consignees = consignee::select(['id', 'firstName', 'middleName','lastName','companyName', 'address','city', 'st_prov', 'zip', 'b_address', 'b_city',
			'b_st_prov', 'b_zip', 'email', 'contactNumber','created_at', 'TIN', 'businessStyle']);

		return Datatables::of($consignees)

		->editColumn('firstName', '{{ $firstName . " " .$middleName . " ". $lastName }}')
		->editColumn('created_at', '{{ Carbon\Carbon::parse($created_at)->toFormattedDateString() }}')
		->addColumn('action', function ($consignee){
			return
			'<button value = "'. $consignee->id .'" class = "btn btn-md btn-primary but edit">Update</button>
			<button value = "'. $consignee->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
			'<input type = "hidden" value = "'. $consignee->firstName .'" class = "firstName" />
			<input type = "hidden" value = "'. $consignee->middleName .'" class = "middleName" />
			<input type = "hidden" value = "'. $consignee->lastName .'" class = "lastName" />
			<input type = "hidden" value = "'. $consignee->companyName .'" class = "companyName" />
			<input type = "hidden" value = "'. $consignee->address .'" class = "address" />
			<input type = "hidden" value = "'. $consignee->city .'" class = "city" />
			<input type = "hidden" value = "'. $consignee->st_prov .'" class = "st_prov" />
			<input type = "hidden" value = "'. $consignee->zip .'" class = "zip" />
			<input type = "hidden" value = "'. $consignee->b_address .'" class = "b_address" />
			<input type = "hidden" value = "'. $consignee->b_city .'" class = "b_city" />
			<input type = "hidden" value = "'. $consignee->b_st_prov .'" class = "b_st_prov" />
			<input type = "hidden" value = "'. $consignee->b_zip .'" class = "b_zip" />
			<input type = "hidden" value = "'. $consignee->email .'" class = "email" />
			<input type = "hidden" value = "'. $consignee->contactNumber .'" class = "contactNumber" />
			<input type = "hidden" value = "'. $consignee->businessStyle .'" class = "businessStyle" />
			<input type = "hidden" value = "'. $consignee->TIN .'" class = "TIN" />'
			;
		})
		->editColumn('consigneeType', function($consignee){
			if( $consignee->consigneeType == 0){
				return 'Walk-in';
			}
			else{
				return 'Regular';
			}
		})
		->make(true);
	}

	public function v_datatable(){
		$vs = DB::table('vehicles')
		->join('vehicle_types', 'vehicle_types_id','=', 'vehicle_types.id')
		->select('name', 'plateNumber', 'model','bodyType','dateRegistered', 'vehicles.created_at')
		->where('vehicles.deleted_at', '=', null)
		->get();


		return Datatables::of($vs)
		->addColumn('action', function ($v) {
			return
			'<button value = "'. $v->plateNumber .'" style="margin-right:10px; width:100;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $v->plateNumber .'" style="width:100;" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->make(true);
	}
	public function brso_head_datatable(){
		$so_heads = DB::table('consignee_service_order_headers')
		->join('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->join('consignee_service_order_details', 'consignee_service_order_details.so_headers_id', '=', 'consignee_service_order_headers.id')
		->join('service_order_types','service_order_types.id','=','consignee_service_order_details.service_order_types_id')
		->select('consignee_service_order_headers.id', 'companyName','service_order_types.name', 'consignee_service_order_details.created_at')
		->where('consignee_service_order_details.service_order_types_id', '=', 1)
		->get();
		return Datatables::of($so_heads)
		->addColumn('action', function ($so_head) {
			return
			'<a href = "/billing/' . $so_head->id . '" style="margin-right:10px; width:100;" class = "btn btn-md but selectCon">Select</a>';
		})
		->make(true);
	}
	public function trso_head_datatable(){
		$so_heads = DB::table('consignee_service_order_headers')
		->join('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->join('consignee_service_order_details', 'consignee_service_order_details.so_headers_id', '=', 'consignee_service_order_headers.id')
		->join('service_order_types','service_order_types.id','=','consignee_service_order_details.service_order_types_id')
		->select('consignee_service_order_headers.id', 'companyName','service_order_types.name','consignee_service_order_details.created_at')
		->where('consignee_service_order_details.service_order_types_id', '=', 2)
		->get();
		return Datatables::of($so_heads)
		->addColumn('action', function ($so_head) {
			return
			'<a href = "/billing/' . $so_head->id . '" style="margin-right:10px; width:100;" class = "btn btn-md but selectCon">Select</a>';
		})
		->make(true);
	}
	public function pso_head_datatable(){
		$bill_hists = DB::select('SELECT t.id,
			C.companyName,
			(CASE t.isRevenue
			WHEN t.isRevenue = 1 THEN "Revenue"
			WHEN t.isRevenue = 0 THEN "Expense"
			END) as isRevenue,
			CONCAT("Php ", (ROUND(((p.total * t.vatRate)/100), 2) + p.total)) as Total,
			DATE_FORMAT(t.due_date, "%M %d, %Y") as due_date


			FROM billing_invoice_headers t LEFT JOIN
			(
			SELECT bi_head_id, SUM(amount) total
			FROM billing_invoice_details
			GROUP BY bi_head_id
			) p
			ON t.id = p.bi_head_id
			JOIN consignee_service_order_headers AS B on t.so_head_id = B.id
			JOIN consignees AS C on B.consignees_id = C.id');

		return Datatables::of($bill_hists)
		->addColumn('action', function ($hist) {
			return
			'<a href = "/payment/'. $hist->id .'" style="margin-right:10px; width:100;" class = "btn btn-md but bill_inv">Select</a>';
		})
		->make(true);
	}
	public function bill_datatable(){
		$bills = Billing::select(['id', 'name', 'bill_type','description', 'created_at']);

		return Datatables::of($bills)
		->addColumn('action', function ($bil){
			return
			'<button value = "'. $bil->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
			'<button value = "'. $bil->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}
	public function expenses_datatable(Request $request)
	{
		$exp = DB::table('billing_invoice_details')
		->join('charges', 'billing_invoice_details.charge_id', '=', 'charges.id')
		->join('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->select('charges.name', 'billing_invoice_details.description', DB::raw('CONCAT(TRUNCATE(billing_invoice_details.amount - (billing_invoice_details.amount * tax/100),2)) as Total'))
		->where([
			['billing_invoice_details.bi_head_id', '=', $request->id],
			['charges.bill_type', '=', 'E']
			])
		->get();
		return Datatables::of($exp)
		->make(true);

		// select b.name, be.description, be.amount from billing_expenses as be left join billing_invoice_headers as bh on be.bi_head_id = bh.id LEFT JOIN billings as b on be.bill_id = b.id where be.bi_head_id = 1
	}
	public function revenue_datatable(Request $request)
	{
		$rev = DB::table('billing_invoice_details')
		->join('charges', 'billing_invoice_details.charge_id', '=', 'charges.id')
		->join('billing_invoice_headers', 'billing_invoice_details.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->select('charges.name', 'billing_invoice_details.description', DB::raw('CONCAT(TRUNCATE(billing_invoice_details.amount - (billing_invoice_details.amount * tax/100),2)) as Total'))
		->where([
			['billing_invoice_details.bi_head_id', '=', $request->id],
			['charges.bill_type', '=', 'R']
			])
		->get();
		return Datatables::of($rev)
		->make(true);
	}

	public function prev_datatable(Request $request)
	{
		$revs = DB::table('billing_revenues')
		->join('billing_invoice_headers', 'billing_revenues.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('billings', 'billing_revenues.bill_id', '=', 'billings.id')
		->select('billings.name', 'billing_revenues.description', DB::raw('CONCAT(TRUNCATE(billing_revenues.amount - (billing_revenues.amount * billing_revenues.tax/100),2)) as Total'))
		->where('billing_invoice_headers.so_head_id', '=', $id)
		->get();
		return Datatables::of($revs)
		->make(true);
	}
	public function shipment_datatable(){
		$shipments = DB::table('brokerage_service_orders')
		->leftjoin('consignee_service_order_headers', 'brokerage_service_orders.consigneeSODetails_id','=', 'consignee_service_order_headers.id')
		->leftjoin('employees','consignee_service_order_headers.employees_id','=','employees.id')
		->leftjoin('consignees','consignee_service_order_headers.consignees_id','=','consignees.id')
		->select('brokerage_service_orders.created_at','consignee_service_order_headers.id',DB::raw('CONCAT(employees.firstName, employees.lastName) as Employee'), 'companyName', 'arrivalArea', 'shipper','deposit')
		->orderBy('brokerage_service_orders.created_at')
		->groupBy(DB::raw('MONTH(brokerage_service_orders.created_at)'))
		->get();
		return Datatables::of($shipments)
		->make(true);
	}
	public function delivery_datatable(Request $request)
	{
		$daily = "";

		switch($request->frequency){
			case 1 :
			$deliveries = DB::select('SELECT CONCAT(firstName, " ", lastName) as name, companyName, B.created_at, shippingLine, portOfCfsLocation, containerVolume,  containerNumber,  DATE_FORMAT(pickupDateTime, "%M %d, %Y") as pickupDateTime, DATE_FORMAT(deliveryDateTime, "%M %d, %Y") as deliveryDateTime, B.remarks FROM  delivery_receipt_headers AS B LEFT JOIN  delivery_containers as A on A.del_head_id = B.id JOIN trucking_service_orders AS C ON B.tr_so_id = C.id JOIN consignee_service_order_details as D ON C.so_details_id = D.id JOIN consignee_service_order_headers AS E ON D.so_headers_id = E.id JOIN consignees AS F ON E.consignees_id = F.id');
			return json_encode($deliveries);
			break;

			case 2 :
			$deliveries = DB::select('SELECT CONCAT(firstName, " ", lastName) as name, companyName, B.created_at, shippingLine, portOfCfsLocation, containerVolume,  containerNumber,  DATE_FORMAT(pickupDateTime, "%M %d, %Y") as pickupDateTime, DATE_FORMAT(deliveryDateTime, "%M %d, %Y") as deliveryDateTime, DATE_FORMAT(deliveryDateTime, "%M %Y") as deliveryDateMonth, B.remarks FROM  delivery_receipt_headers AS B LEFT JOIN  delivery_containers as A on A.del_head_id = B.id JOIN trucking_service_orders AS C ON B.tr_so_id = C.id JOIN consignee_service_order_details as D ON C.so_details_id = D.id JOIN consignee_service_order_headers AS E ON D.so_headers_id = E.id JOIN consignees AS F ON E.consignees_id = F.id');
			return json_encode($deliveries);
			break;

			case 3 :
			$deliveries = DB::select('SELECT CONCAT(firstName, " ", lastName) as name, companyName, B.created_at, shippingLine, portOfCfsLocation, containerVolume,  containerNumber,  DATE_FORMAT(pickupDateTime, "%M %d, %Y") as pickupDateTime, DATE_FORMAT(deliveryDateTime, "%M %d, %Y") as deliveryDateTime, DATE_FORMAT(deliveryDateTime, "%Y") as deliveryDateYear, B.remarks FROM  delivery_receipt_headers AS B LEFT JOIN  delivery_containers as A on A.del_head_id = B.id JOIN trucking_service_orders AS C ON B.tr_so_id = C.id JOIN consignee_service_order_details as D ON C.so_details_id = D.id JOIN consignee_service_order_headers AS E ON D.so_headers_id = E.id JOIN consignees AS F ON E.consignees_id = F.id');
			return json_encode($deliveries);
			break;

			case 4 :
			$deliveries = DB::select('SELECT CONCAT(firstName, " ", lastName) as name, companyName, B.created_at, shippingLine, portOfCfsLocation, containerVolume,  containerNumber,  DATE(pickupDateTime) as pickupDateTime, DATE(deliveryDateTime) as deliveryDateTime, DATE_FORMAT(pickupDateTime, "%M %d, %Y") as dpickupDateTime, DATE_FORMAT(deliveryDateTime, "%M %d, %Y") as ddeliveryDateTime, B.remarks FROM  delivery_receipt_headers AS B LEFT JOIN  delivery_containers as A on A.del_head_id = B.id JOIN trucking_service_orders AS C ON B.tr_so_id = C.id JOIN consignee_service_order_details as D ON C.so_details_id = D.id JOIN consignee_service_order_headers AS E ON D.so_headers_id = E.id JOIN consignees AS F ON E.consignees_id = F.id WHERE DATE(deliveryDateTime) BETWEEN ? AND ?', [$request->date_from, $request->date_to]);
			return json_encode($deliveries);
		}


	}

	public function ar_datatable(){
		$ars = Area::select(['id', 'description', 'created_at']);

		return Datatables::of($ars)
		->addColumn('action', function ($ar){
			return
			'<button value = "'. $ar->id .'"   style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $ar->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function lp_datatable(){
		$lps = LocationProvince::select(['id', 'name', 'created_at']);

		return Datatables::of($lps)
		->addColumn('action', function ($lp){
			return
			'<button value = "'. $lp->id .'"   style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $lp->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}


	public function lc_datatable(){
		$lcs = DB::select("SELECT p.name as 'province' , c.name as 'city', c.id as'id'  FROM location_provinces p INNER JOIN location_cities c ON p.id = c.provinces_id where c.deleted_at is null  and p.deleted_at is null order by p.name");

		return Datatables::of($lcs)
		->addColumn('action', function ($lc){
			return
			'<button value = "'. $lc->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
			'<button value = "'. $lc->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}




	public function bl_datatable(){
		$bills = Billing::select(['id', 'name', 'description', 'created_at']);

		return Datatables::of($bills)
		->addColumn('action', function ($bill){
			return
			'<button value = "'. $bill->id .'" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $bill->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function bf_datatable(){
		$bfs = DB::select("SELECT h.id, h.dateEffective, h.deleted_at , GROUP_CONCAT(d.minimum ORDER BY d.minimum ASC ) AS minimum, GROUP_CONCAT(d.maximum ORDER BY d.minimum ASC ) AS maximum, GROUP_CONCAT(d.amount ORDER BY d.minimum ASC) AS amount FROM brokerage_fee_headers h INNER JOIN brokerage_fee_details d ON h.id = d.brokerage_fee_headers_id where h.deleted_at is null GROUP BY h.id");

		return Datatables::of($bfs)
		->addColumn('action', function ($bf){
			return
			'<button value = "'. $bf->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $bf->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function contracts_datatable(){
		$contract_headers = DB::table('contract_headers')
		->join('consignees', 'consignees_id', '=', 'consignees.id')
		->select('contract_headers.id', 'dateEffective', 'isFinalize', 'dateExpiration', 'companyName', 'contract_headers.created_at')
		->get();
		return Datatables::of($contract_headers)
		->addColumn('status', function ($contract_header){
			if ($contract_header->isFinalize == 1){

				$date_now = Carbon::now();
				if($date_now->between(Carbon::parse($contract_header->dateEffective), Carbon::parse($contract_header->dateExpiration))){
					return 'Active';
				}
				else if(Carbon::parse($contract_header->dateEffective)->isPast()){
					return 'Expired';
				}

			}else{
				return 'Draft';
			}



		})
		->addColumn('action', function ($contract_header){
			if ($contract_header->isFinalize == 1){

				return
				'<button value = "'. $contract_header->id .'" class = "btn btn-md but view-contract-details">View</button>' .
				'<button value = "'. $contract_header->id .'" class = "btn btn-md btn-primary amend-contract">Amend</button>' .
				'<button value = "'. $contract_header->id .'" class = "btn btn-md btn-success print-contract-details">Print</button>';

			}else{
				return
				'<button value = "'. $contract_header->id .'" class = "btn btn-md btn-primary update-draft">Update</button>';
			}
		})
		->editColumn('id', '{{ $id }}')
		->editColumn('dateEffective', function($contract_header){
			return $contract_header->dateEffective ? with(new Carbon ($contract_header->dateEffective))->toFormattedDateString() : 'Pending';
		})
		->editColumn('dateExpiration', function($contract_header){

			return $contract_header->dateExpiration ? with(new Carbon ($contract_header->dateExpiration))->toFormattedDateString()  : 'Pending';



		})
		->editColumn('created_at', '{{ Carbon\Carbon::parse($created_at)->toFormattedDateString() }}')
		->make(true);
	}

	public function employees_datatable(){
		$employees = DB::table('employees')
		->select('employees.id', 'firstName', 'middleName', 'lastName','employees.created_at')
		->where('deleted_at', '=', null)
		->get();
		return Datatables::of($employees)
		->addColumn('action', function ($employee){
			return
			'<a href = "/utilities/employee/' . $employee->id . '/view" class = "btn but btn-md">View</a>' .
			'<button value = "'. $employee->id .'" class = "btn btn-md btn-primary edit">Update</button>'.
			'<button value = "'. $employee->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function emp_role_datatable(Request $request){
		$id = $request->employee_id;
		$employee_roles = DB::table('employee_roles')
		->join('employees', 'employee_id', '=', 'employees.id')
		->join('employee_types', 'employee_type_id', '=', 'employee_types.id')
		->select('employee_roles.id', 'name','employee_roles.created_at')
		->where('employee_id', '=', $id)
		->where('employee_roles.deleted_at', '=', null)
		->get();
		return Datatables::of($employee_roles)
		->addColumn('action', function ($employee_role){
			return
			'<button value = "'. $employee_role->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->make(true);
	}


	public function trucking_so_datatable(){
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
		return Datatables::of($truckings)
		->addColumn('action', function ($trucking){
			return
			'<a href = "/trucking/'. $trucking->id .'/view" class = "btn btn-md but view-service-order">Manage</a>';
		})
		->editColumn('status', function($trucking){
			switch ($trucking->status) {
				case 'F':
				return 'Finished';
				break;
				case 'P':
				return 'Pending';
				break;
				case 'C':
				return 'Cancelled';
				break;
				default:
				return 'Unknown';
				break;
			}
		})
		->make(true);
	}

	public function trucking_delivery(Request $request){

	}

	public function get_trucking_deliveries(Request $request)
	{
		$deliveries = DB::table('delivery_receipt_headers')
		->join('locations as A', 'locations_id_pick', '=', 'A.id')
		->join('locations as B', 'locations_id_del', '=', 'B.id')
		->join('location_cities as C', 'A.cities_id', '=', 'C.id')
		->join('location_cities as D', 'B.cities_id', '=', 'D.id')
		->select('delivery_receipt_headers.id', 'plateNumber', 'delivery_receipt_headers.created_at', 'status', 'A.name AS pickup_name', 'B.name as deliver_name', 'C.name AS pickup_city', 'D.name AS deliver_city', 'delivery_receipt_headers.deliveryDateTime', 'pickupDateTime')
		->where('delivery_receipt_headers.deleted_at', '=', null)
		->where('tr_so_id','=', $request->trucking_id)
		->get();

		return Datatables::of($deliveries)
		->addColumn('created_at_date', function($delivery){
			return
			Carbon::parse($delivery->created_at)->diffForHumans();
		})
		->editColumn('deliveryDateTime', function($deliveries){
			return Carbon::parse($deliveries->deliveryDateTime)->format('F j, Y h:i:s A');
		})
		->editColumn('pickupDateTime', function($deliveries){
			return Carbon::parse($deliveries->pickupDateTime)->format('F j, Y h:i:s A');
		})
		->addColumn('action', function ($delivery){
			if($delivery->status == 'P'){
				return
				"<button class = 'btn btn-info view_delivery' title = 'View'><span class = 'fa fa-eye'></span></button>
				<button class = 'btn btn-primary edit_delivery' title = 'Edit'><span class = 'fa fa-edit'></span></button>
				<button class = 'btn but select-delivery' data-toggle = 'modal' data-target = '#deliveryModal' title = 'Status'><span class = 'fa-flag-o fa'></span></button>" .
				"<input type = 'hidden' value = '" . $delivery->id . "' class = 'delivery-id' />";
			}
			if($delivery->status == 'F' || $delivery->status == 'C'){
				return
				"<button class = 'btn btn-info view_delivery' title = 'View'><span class = 'fa fa-eye'></span></button>
				<button disabled class = 'btn btn-primary edit_delivery' title = 'Edit'><span class = 'fa fa-edit'></span></button>
				<button disabled class = 'btn but select-delivery' data-toggle = 'modal' data-target = '#deliveryModal' title = 'Status'><span class = 'fa-flag-o fa'></span></button>" .
				"<input type = 'hidden' value = '" . $delivery->id . "' class = 'delivery-id' />";
			}
		})
		->editColumn('status', function($deliveries){
			switch ($deliveries->status) {
				case 'F':
				return 'Finished';
				break;
				case 'P':
				return 'Pending';
				break;
				case 'C':
				return 'Cancelled';
				break;

				default:
				return 'Unknown';
				break;
			}
		})
		->make(true);
	}


	public function location_datatable(){
		$locations = DB::table('locations')
		->join('location_cities AS B', 'locations.cities_id', '=', 'B.id')
		->join('location_provinces AS C', 'B.provinces_id', '=', 'C.id')
		->select('locations.id as location_id', 'locations.name AS location_name', 'locations.address AS location_address', 'B.name AS city_name', 'C.name AS province_name', 'B.id AS city_id', 'C.id AS province_id', 'locations.zipCode')
		->where('locations.deleted_at', '=', null)
		->orderBy('location_name')
		->get();

		return Datatables::of($locations)
		->addColumn('action', function ($location){
			return
			'<input type = "hidden" class = "location_id"  value = "' . $location->location_id . '"/>'.
			'<input type = "hidden" class = "province_id"  value = "' . $location->province_id . '"/>' .
			'<input type = "hidden" class = "city_id" value = "' . $location->city_id . '"/>' .
			'<button value = "'. $location->location_id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
			'<button value = "'. $location->location_id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';

		})
		->make(true);
	}

	public function get_quotations(){
		$quotations = DB::table('quotation_headers')
		->select(DB::raw('CONCAT(firstName, " ", lastName) as name'), 'quotation_headers.id', 'quotation_headers.created_at')
		->join('consignees', 'consignees_id', '=', 'consignees.id')
		->where('quotation_headers.deleted_at', '=', null)
		->get();

		return Datatables::of($quotations)
		->editColumn('created_at', '{{ Carbon\Carbon::parse($created_at)->toFormattedDateString() }}')
		->addColumn('action', function ($quotation){
			return
			'<button value = "'. $quotation->id .'" class = "btn btn-md but view">View</button>
			<button value = "'. $quotation->id .'" class = "btn btn-md btn-success print">Print</button>
			<button value = "'. $quotation->id .'" class = "btn btn-md btn-danger archive">Archive</button>';
		})
		->editColumn('id', '{{ $id }}')


		->make(true);
	}


	public function get_active_contract(Request $request){
		switch ($request->status) {
			case "A" :
			$contracts = DB::table('contract_headers')
			->join('consignees AS A', 'consignees_id', '=', 'A.id')
			->select('dateEffective', 'dateExpiration', DB::raw('CONCAT(firstName , " " , lastName) as name'), 'contract_headers.id', 'contract_headers.created_at')
			->whereRaw('NOW() BETWEEN dateEffective AND dateExpiration')
			->get();

			return Datatables::of($contracts)
			->addColumn('status', function ($contract_header){
				$date_now = Carbon::now();
				if($date_now->between(Carbon::parse($contract_header->dateEffective), Carbon::parse($contract_header->dateExpiration))){
					return 'Active';
				}
				else if(Carbon::parse($contract_header->dateEffective)->isPast()){
					return 'Expired';
				}
				else{
					return 'Pending';
				}

			})

			->editColumn('dateExpiration', '{{ Carbon\Carbon::parse($dateExpiration)->diffForHumans() }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->toFormattedDateString() }}')
			->make(true);
			break;

			case "E" :
			$contracts = DB::table('contract_headers')
			->join('consignees AS A', 'consignees_id', '=', 'A.id')
			->select('dateEffective', 'dateExpiration', DB::raw('CONCAT(firstName , " " , lastName) as name'), 'contract_headers.id', 'contract_headers.created_at')
			->whereRaw('NOW() > dateExpiration')
			->get();

			return Datatables::of($contracts)
			->addColumn('status', function ($contract_header){
				$date_now = Carbon::now();
				if($date_now->between(Carbon::parse($contract_header->dateEffective), Carbon::parse($contract_header->dateExpiration))){
					return 'Active';
				}
				else if(Carbon::parse($contract_header->dateEffective)->isPast()){
					return 'Expired';
				}
				else{
					return 'Pending';
				}

			})

			->editColumn('dateExpiration', '{{ Carbon\Carbon::parse($dateExpiration)->diffForHumans() }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->toFormattedDateString() }}')
			->make(true);
			break;

			case "D" :
			$contracts = DB::table('contract_headers')
			->join('consignees AS A', 'consignees_id', '=', 'A.id')
			->select('dateEffective', 'dateExpiration', DB::raw('CONCAT(firstName , " " , lastName) as name'), 'contract_headers.id', 'contract_headers.created_at')
			->where('isFinalize', '=', 1)
			->get();

			return Datatables::of($contracts)
			->addColumn('status', function ($contract_header){
				$date_now = Carbon::now();
				if($date_now->between(Carbon::parse($contract_header->dateEffective), Carbon::parse($contract_header->dateExpiration))){
					return 'Active';
				}
				else if(Carbon::parse($contract_header->dateEffective)->isPast()){
					return 'Expired';
				}
				else{
					return 'Pending';
				}

			})

			->editColumn('dateExpiration', '{{ Carbon\Carbon::parse($dateExpiration)->diffForHumans() }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->toFormattedDateString() }}')
			->make(true);
			break;

		}

	}

	public function get_pending_deliveries(Request $request){
		switch($request->status)
		{
			case 'P' :
			$deliveries = DB::table('delivery_receipt_headers')
			->select('delivery_receipt_headers.id', DB::raw('CONCAT(firstName, " ", lastName) as name'), 'pickupDateTime', 'deliveryDateTime', 'G.name as city_name', 'H.name as province_name', 'I.name as dcity_name', 'J.name as dprovince_name', 'plateNumber')
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
			->get();

			return Datatables::of($deliveries)
			->addColumn('action', function ($delivery){
				return
				'<button value = "'. $delivery->id .'" class = "btn btn-md but view">View</button>';
			})
			->editColumn('deliveryDateTime', '{{ Carbon\Carbon::parse($deliveryDateTime)->toFormattedDateString() }}')
			->editColumn('pickupDateTime', '{{ Carbon\Carbon::parse($pickupDateTime)->toFormattedDateString() }}')

			->make(true);

			break;

			case 'C' :

			$deliveries = DB::table('delivery_receipt_headers')
			->select('delivery_receipt_headers.id', DB::raw('CONCAT(firstName, " ", lastName) as name'), 'pickupDateTime', 'deliveryDateTime', 'G.name as city_name', 'H.name as province_name', 'I.name as dcity_name', 'J.name as dprovince_name', 'plateNumber')
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
			->where('delivery_receipt_headers.status', '=', 'C')
			->get();

			return Datatables::of($deliveries)
			->addColumn('action', function ($delivery){
				return
				'<button value = "'. $delivery->id .'" class = "btn btn-md but view">View</button>';
			})
			->editColumn('deliveryDateTime', '{{ Carbon\Carbon::parse($deliveryDateTime)->toFormattedDateString() }}')
			->editColumn('pickupDateTime', '{{ Carbon\Carbon::parse($pickupDateTime)->toFormattedDateString() }}')

			->make(true);

			break;

			case 'T' :

			$deliveries = DB::table('delivery_receipt_headers')
			->select('delivery_receipt_headers.id', DB::raw('CONCAT(firstName, " ", lastName) as name'), 'pickupDateTime', 'deliveryDateTime', 'G.name as city_name', 'H.name as province_name', 'I.name as dcity_name', 'J.name as dprovince_name', 'plateNumber')
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
			->whereRaw('DATE("deliveryDateTime") = DATE("CURDATE()")')
			->get();

			return Datatables::of($deliveries)
			->addColumn('action', function ($delivery){
				return
				'<button value = "'. $delivery->id .'" class = "btn btn-md but view">View</button>';
			})
			->editColumn('deliveryDateTime', '{{ Carbon\Carbon::parse($deliveryDateTime)->toFormattedDateString() }}')
			->editColumn('pickupDateTime', '{{ Carbon\Carbon::parse($pickupDateTime)->toFormattedDateString() }}')

			->make(true);

			break;
		}

	}

	public function get_unreturned_containers(Request $request){
		$containers = DB::table('delivery_containers')
		->select('containerNumber', 'containerReturnDate', 'containerVolume', 'containerReturnAddress', 'containerReturnTo')
		->where('containerReturnStatus', '=', 'N')
		->get();

		return Datatables::of($containers)
		->editColumn('containerReturnDate', function($container){
			return Carbon::parse($container->containerReturnDate)->toFormattedDateString();
		})
		->make(true);

	}

	public function get_query_bills(Request $request)
	{
		switch ($request->status) {
			case 'N' :
			$bills = DB::table('billing_invoice_headers')
			->join('consignee_service_order_headers as A', 'so_head_id', '=', 'A.id')
			->join('consignees as B', 'A.consignees_id', '=', 'B.id')
			->select('billing_invoice_headers.id', DB::raw('CONCAT(firstName , " ", lastName) as name'), 'due_date', 'status')
			->whereRaw('NOW() <= due_date')
			->get();
			return Datatables::of($bills)
			->addColumn('action', function ($bill){
				return
				'<button value = "'. $bill->id .'" style="margin-right:10px;" class = "btn btn-md but edit">View</button>';
			})
			->editColumn('due_date', function($bill){
				return Carbon::parse($bill->due_date)->toFormattedDateString();
			})
			->editColumn('status', function($bill){
				switch ($bill->status) {
					case 'U':
					return 'Unpaid';
					break;
					case 'P':
					return 'Paid';
					break;

					default:
					return 'Unknown';
					break;
				}
			})
			->make(true);
			break;

			case 'O' :
			$bills = DB::table('billing_invoice_headers')
			->join('consignee_service_order_headers as A', 'so_head_id', '=', 'A.id')
			->join('consignees as B', 'A.consignees_id', '=', 'B.id')
			->select('billing_invoice_headers.id', DB::raw('CONCAT(firstName , " ", lastName) as name'), 'due_date', 'status')
			->whereRaw('NOW() > due_date')
			->get();
			return Datatables::of($bills)
			->addColumn('action', function ($bill){
				return
				'<button value = "'. $bill->id .'" style="margin-right:10px;" class = "btn btn-md but edit">View</button>';
			})
			->editColumn('due_date', function($bill){
				return Carbon::parse($bill->due_date)->toFormattedDateString();
			})
			->editColumn('status', function($bill){
				switch ($bill->status) {
					case 'U':
					return 'Unpaid';
					break;
					case 'P':
					return 'Paid';
					break;

					default:
					return 'Unknown';
					break;
				}
			})
			->make(true);
			break;

		}
	}

	public function cds_datatable(){
		$cdss = CdsFee::select(['id',  'fee', 'dateEffective', 'created_at']);

		return Datatables::of($cdss)
		->addColumn('action', function ($cds){
			return
			'<button value = "'. $cds->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
			'<button value = "'. $cds->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function vr_datatable(){
		$vrs = VatRate::select(['id',  'rate', 'dateEffective', 'created_at']);

		return Datatables::of($vrs)
		->addColumn('action', function ($vrs){
			return
			'<button value = "'. $vrs->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
			'<button value = "'. $vrs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function ipf_datatable(){
		$ipfs = DB::select("SELECT h.id, h.dateEffective , GROUP_CONCAT(d.minimum ORDER BY d.minimum ASC ) AS minimum, GROUP_CONCAT(d.maximum ORDER BY d.minimum ASC ) AS maximum, GROUP_CONCAT(d.amount ORDER BY d.minimum ASC) AS amount FROM import_processing_fee_headers h INNER JOIN import_processing_fee_details d ON h.id = d.ipf_headers_id GROUP BY h.id");

		return Datatables::of($ipfs)
		->addColumn('action', function ($ipf){
			return
			'<button value = "'. $ipf->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
			'<button value = "'. $ipf->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}


	public function sar_datatable(){
		$sars = DB::select("select s.id , f.id as'pickup_id', l.id as 'deliver_id', l.name as 'areaTo' ,f.name as 'areaFrom' ,s.amount from standard_area_rates s  JOIN locations as l on s.areaTo = l.id join locations as f on s.areaFrom = f.id  where s.deleted_at is null and l.deleted_at is null");

		return Datatables::of($sars)
		->addColumn('action', function ($sar){
			return
			'<button value = "'. $sar->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
			'<button value = "'. $sar->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
			'<input type = "hidden" value = "'. $sar->pickup_id .'" class = "pickup_id"/>
			<input type = "hidden" value = "'. $sar->deliver_id .'"class = "deliver_id"/>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function get_finished_trucking_orders(Request $request){
		$truckings = DB::table('trucking_service_orders')
		->join('consignee_service_order_details as A', 'trucking_service_orders.so_details_id', '=', 'A.id')
		->join('consignee_service_order_headers as B', 'A.so_headers_id', '=', 'B.id')
		->join('consignees as C', 'B.consignees_id', '=', 'C.id')
		->join('employees as D', 'B.employees_id', '=', 'D.id')
		->select('trucking_service_orders.id', DB::raw('CONCAT(C.firstName, " ", C.lastName) as consignee'), DB::raw('CONCAT(D.firstName, " ", D.lastName) as employee'))
		->where('trucking_service_orders.status', '=', 'F')
		->get();

		return Datatables::of($truckings)
		->addColumn('action', function ($trucking){
			return
			'<button value = "'. $trucking->id .'" style="margin-right:10px;" class = "btn btn-md but view-finish">View</button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}





	public function cds_deactivated(Request $request){
		$cds;
		if ($request->filter == 0){
			$cds = DB::table('cds_fees')
			->select('id',  'fee', 'dateEffective', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($cds)
			->addColumn('action', function ($cds){
				if ($cds->deleted_at == null){
					return
					'<button value = "'. $cds->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $cds->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($cds){
				if ($cds->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$cds = DB::table('cds_fees')
			->select('id',  'fee', 'dateEffective', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($cds)
			->addColumn('action', function ($cds){
				return
				'<button value = "'. $cds->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($cds){
				if ($cds->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$cds = DB::table('cds_fees')
			->select('id',  'fee', 'dateEffective', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($cds)
			->addColumn('status', function ($cds){
				if ($cds->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($cds){
				return
				'<button value = "'. $cds->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function


	public function bf_deactivated(Request $request){
		$bfs;
		if ($request->filter == 0){
			$bfs = DB::select("SELECT h.id, h.dateEffective AS dateEffective , GROUP_CONCAT(d.minimum ORDER BY d.minimum ASC ) AS minimum, GROUP_CONCAT(d.maximum ORDER BY d.minimum ASC ) AS maximum, GROUP_CONCAT(d.amount ORDER BY d.minimum ASC) AS amount, h.created_at, h.deleted_at FROM brokerage_fee_headers h INNER JOIN brokerage_fee_details d ON h.id = d.brokerage_fee_headers_id GROUP BY h.id");


			return Datatables::of($bfs)
			->addColumn('action', function ($bfs){
				if ($bfs->deleted_at == null){
					return
					'<button value = "'. $bfs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $bfs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($bfs){
				if ($bfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$bfs = DB::select("SELECT h.id, h.dateEffective AS dateEffective , GROUP_CONCAT(d.minimum ORDER BY d.minimum ASC ) AS minimum, GROUP_CONCAT(d.maximum ORDER BY d.minimum ASC ) AS maximum, GROUP_CONCAT(d.amount ORDER BY d.minimum ASC) AS amount, h.created_at, h.deleted_at FROM brokerage_fee_headers h INNER JOIN brokerage_fee_details d ON h.id = d.brokerage_fee_headers_id  WHERE h.deleted_at IS NULL GROUP BY h.id");

			return Datatables::of($bfs)
			->addColumn('action', function ($bfs){
				return
				'<button value = "'. $bfs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($bfs){
				if ($bfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$bfs = DB::select("SELECT h.id, h.dateEffective AS dateEffective , GROUP_CONCAT(d.minimum ORDER BY d.minimum ASC ) AS minimum, GROUP_CONCAT(d.maximum ORDER BY d.minimum ASC ) AS maximum, GROUP_CONCAT(d.amount ORDER BY d.minimum ASC) AS amount, h.created_at, h.deleted_at FROM brokerage_fee_headers h INNER JOIN brokerage_fee_details d ON h.id = d.brokerage_fee_headers_id  WHERE h.deleted_at IS NOT NULL GROUP BY h.id");


			return Datatables::of($bfs)
			->addColumn('status', function ($bfs){
				if ($bfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($bfs){
				return
				'<button value = "'. $bfs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function



	public function ch_deactivated(Request $request){
		$chs;
		if ($request->filter == 0){
			$chs = DB::table('charges')
			->select('id', 'name','description', 'chargeType','amount','created_at', 'deleted_at')
			->get();

			return Datatables::of($chs)
			->addColumn('action', function ($chs){
				if ($chs->deleted_at == null){
					return
					'<button value = "'. $chs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $chs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($chs){
				if ($chs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$chs = DB::table('charges')
			->select('id', 'name','description', 'chargeType','amount','created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($chs)
			->addColumn('action', function ($chs){
				return
				'<button value = "'. $chs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($chs){
				if ($chs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$chs = DB::table('charges')
			->select('id', 'name','description', 'chargeType','amount', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($chs)
			->addColumn('status', function ($chs){
				if ($chs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($chs){
				return
				'<button value = "'. $chs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function



	public function ct_deactivated(Request $request){
		$cts;
		if ($request->filter == 0){
			$cts = DB::table('container_types')
			->select('id','name', 'description','maxWeight', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($cts)
			->addColumn('action', function ($cts){
				if ($cts->deleted_at == null){
					return
					'<button value = "'. $cts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $cts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($cts){
				if ($cts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$cts = DB::table('container_types')
			->select('id', 'name', 'description','maxWeight', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($cts)
			->addColumn('action', function ($cts){
				return
				'<button value = "'. $cts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($cts){
				if ($cts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$cts = DB::table('container_types')
			->select('id','name', 'description','maxWeight', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($cts)
			->addColumn('status', function ($cts){
				if ($cts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($cts){
				return
				'<button value = "'. $cts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function


	public function bst_deactivated(Request $request){
		$bsts;
		if ($request->filter == 0){
			$bsts = DB::table('brokerage_status_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($bsts)
			->addColumn('action', function ($bsts){
				if ($bsts->deleted_at == null){
					return
					'<button value = "'. $bsts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $bsts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($bsts){
				if ($bsts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$bsts = DB::table('brokerage_status_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($bsts)
			->addColumn('action', function ($bsts){
				return
				'<button value = "'. $bsts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($bsts){
				if ($bsts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$bsts = DB::table('brokerage_status_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($bsts)
			->addColumn('status', function ($bsts){
				if ($bsts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($bsts){
				return
				'<button value = "'. $bsts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function


	public function et_deactivated(Request $request){
		$ets;
		if ($request->filter == 0){
			$ets = DB::table('employee_types')
			->select('id', 'name', 'description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($ets)
			->addColumn('action', function ($ets){
				if ($ets->deleted_at == null){
					return
					'<button value = "'. $ets->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $ets->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($ets){
				if ($ets->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$ets = DB::table('employee_types')
			->select('id','name', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($ets)
			->addColumn('action', function ($ets){
				return
				'<button value = "'. $ets->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($ets){
				if ($ets->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$ets = DB::table('employee_types')
			->select('id','name', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($ets)
			->addColumn('status', function ($ets){
				if ($ets->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($ets){
				return
				'<button value = "'. $ets->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function





	public function er_deactivated(Request $request){
		$ers;
		if ($request->filter == 0){
			$ers = DB::table('exchange_rates')
			->select('id', 'description', 'rate', 'dateEffective', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($ers)
			->addColumn('action', function ($ers){
				if ($ers->deleted_at == null){
					return
					'<button value = "'. $ers->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $ers->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($ers){
				if ($ers->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$ers = DB::table('exchange_rates')
			->select('id', 'description', 'rate', 'dateEffective', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($ers)
			->addColumn('action', function ($ers){
				return
				'<button value = "'. $ers->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($ers){
				if ($ers->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$ers = DB::table('exchange_rates')
			->select('id', 'description', 'rate', 'dateEffective', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($ers)
			->addColumn('status', function ($ers){
				if ($ers->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($ers){
				return
				'<button value = "'. $ers->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function




	public function ipf_deactivated(Request $request){
		$ipfs;
		if ($request->filter == 0){

			$ipfs = DB::select("SELECT h.id, h.dateEffective , GROUP_CONCAT(d.minimum ORDER BY d.minimum ASC ) AS minimum, GROUP_CONCAT(d.maximum ORDER BY d.minimum ASC ) AS maximum, GROUP_CONCAT(d.amount ORDER BY d.minimum ASC) AS amount, h.created_at, h.deleted_at FROM import_processing_fee_headers h INNER JOIN import_processing_fee_details d ON h.id = d.ipf_headers_id GROUP BY h.id");


			return Datatables::of($ipfs)
			->addColumn('action', function ($ipfs){
				if ($ipfs->deleted_at == null){
					return
					'<button value = "'. $ipfs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $ipfs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($ipfs){
				if ($ipfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$ipfs = DB::select("SELECT h.id, h.dateEffective , GROUP_CONCAT(d.minimum ORDER BY d.minimum ASC ) AS minimum, GROUP_CONCAT(d.maximum ORDER BY d.minimum ASC ) AS maximum, GROUP_CONCAT(d.amount ORDER BY d.minimum ASC) AS amount, h.created_at, h.deleted_at FROM import_processing_fee_headers h INNER JOIN import_processing_fee_details d ON h.id = d.ipf_headers_id WHERE h.deleted_at IS NULL GROUP BY h.id");

			return Datatables::of($ipfs)
			->addColumn('action', function ($ipfs){
				return
				'<button value = "'. $ipfs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($ipfs){
				if ($ipfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$ipfs = DB::select("SELECT h.id, h.dateEffective , GROUP_CONCAT(d.minimum ORDER BY d.minimum ASC ) AS minimum, GROUP_CONCAT(d.maximum ORDER BY d.minimum ASC ) AS maximum, GROUP_CONCAT(d.amount ORDER BY d.minimum ASC) AS amount, h.created_at, h.deleted_at FROM import_processing_fee_headers h INNER JOIN import_processing_fee_details d ON h.id = d.ipf_headers_id WHERE h.deleted_at IS NOT NULLGROUP BY h.id");

			return Datatables::of($ipfs)
			->addColumn('status', function ($ipfs){
				if ($ipfs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($ipfs){
				return
				'<button value = "'. $ipfs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function

	public function rt_deactivated(Request $request){
		$rts;
		if ($request->filter == 0){
			$rts = DB::table('receive_types')
			->select('id', 'name','description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($rts)
			->addColumn('action', function ($rts){
				if ($rts->deleted_at == null){
					return
					'<button value = "'. $rts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $rts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($rts){
				if ($rts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$rts = DB::table('receive_types')
			->select('id','name', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($rts)
			->addColumn('action', function ($rts){
				return
				'<button value = "'. $rts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($rts){
				if ($rts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$rts = DB::table('receive_types')
			->select('id','name', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($rts)
			->addColumn('status', function ($rts){
				if ($rts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($rts){
				return
				'<button value = "'. $rts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function


	public function sot_deactivated(Request $request){
		$sots;
		if ($request->filter == 0){
			$sots = DB::table('service_order_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($sots)
			->addColumn('action', function ($sots){
				if ($sots->deleted_at == null){
					return
					'<button value = "'. $sots->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $sots->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($sots){
				if ($sots->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$sots = DB::table('service_order_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($sots)
			->addColumn('action', function ($sots){
				return
				'<button value = "'. $sots->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($sots){
				if ($sots->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$sots = DB::table('service_order_types')
			->select('id', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($sots)
			->addColumn('status', function ($sots){
				if ($sots->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($sots){
				return
				'<button value = "'. $sots->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function


	public function vt_deactivated(Request $request){
		$vts;
		if ($request->filter == 0){
			$vts = DB::table('vehicle_types')
			->select('id','name','withContainer', 'description', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($vts)
			->addColumn('action', function ($vts){
				if ($vts->deleted_at == null){
					return
					'<button value = "'. $vts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $vts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($vts){
				if ($vts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$vts = DB::table('vehicle_types')
			->select('id', 'name','withContainer','description', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($vts)
			->addColumn('action', function ($vts){
				return
				'<button value = "'. $vts->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($vts){
				if ($vts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$vts = DB::table('vehicle_types')
			->select('id', 'name','withContainer', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($vts)
			->addColumn('status', function ($vts){
				if ($vts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($vts){
				return
				'<button value = "'. $vts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function





	public function v_deactivated(Request $request){
		$vs;
		if ($request->filter == 0){
			$vs = DB::table('vehicles')
			->join('vehicle_types', 'vehicle_types_id','=', 'vehicle_types.id')
			->select('name', 'plateNumber', 'model','bodyType','dateRegistered', 'vehicles.created_at', 'vehicles.deleted_at')
			->where('vehicles.deleted_at', '=', null)
			->get();

			return Datatables::of($vs)
			->addColumn('action', function ($vs){
				if ($vs->deleted_at == null){
					return
					'<button value = "'. $vs->plateNumber .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $vs->plateNumber .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($vs){
				if ($vs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('plateNumber', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$vs = DB::table('vehicles')
			->join('vehicle_types', 'vehicle_types_id','=', 'vehicle_types.id')
			->select('name', 'plateNumber', 'model','bodyType','dateRegistered', 'vehicles.created_at','vehicles.deleted_at')
			->where('vehicles.deleted_at', '=', null)
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($vs)
			->addColumn('action', function ($vs){
				return
				'<button value = "'. $vs->plateNumber.'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($vs){
				if ($vs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('plateNumber', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$vs = DB::table('vehicles')
			->join('vehicle_types', 'vehicle_types_id','=', 'vehicle_types.id')
			->select('name', 'plateNumber', 'model','bodyType','dateRegistered', 'vehicles.created_at','vehicles.deleted_at')
			->where('vehicles.deleted_at', '!=', null)
			->orderBy('deleted_at', 'desc')
			->get();

			return Datatables::of($vs)
			->addColumn('status', function ($vs){
				if ($vs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($vs){
				return
				'<button value = "'. $vs->plateNumber .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('plateNumber', '{{ $id }}')
			->make(true);
		}
	}//function

	public function lp_deactivated(Request $request){
		$lps;
		if ($request->filter == 0){
			$lps = DB::table('location_provinces')
			->select('id', 'name', 'created_at', 'deleted_at')
			->get();

			return Datatables::of($lps)

			->addColumn('action', function ($lps){
				if ($lps->deleted_at == null){
					return
					'<button value = "'. $lps->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $lps->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($lps){
				if ($lps->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){

			$lps = DB::table('location_provinces')
			->select('id', 'name', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($lps)

			->addColumn('action', function ($lps){
				if ($lps->deleted_at == null){
					return
					'<button value = "'. $lps->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $lps->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($lps){
				if ($lps->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 2){
			$lps = DB::table('location_provinces')
			->select('id', 'name', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($lps)
			->addColumn('action', function ($lps){
				if ($lps->deleted_at == null){
					return
					'<button value = "'. $lps->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $lps->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($lps){
				if ($lps->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function


	public function lc_deactivated(Request $request){
		$lcs;
		if ($request->filter == 0){
			$lcs = DB::select("SELECT p.name as 'province' , c.name as 'city', c.id as'id' ,c.deleted_at as'deleted_at',c.created_at  FROM location_provinces p INNER JOIN location_cities c ON p.id = c.provinces_id where  p.deleted_at is null  order by p.name");

			return Datatables::of($lcs)

			->addColumn('action', function ($lcs){
				if ($lcs->deleted_at == null){
					return
					'<button value = "'. $lcs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $lcs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($lcs){
				if ($lcs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){

			$lcs = DB::select("SELECT p.name as 'province' , c.name as 'city', c.id as'id',c.deleted_at as 'deleted_at'  FROM location_provinces p INNER JOIN location_cities c ON p.id = c.provinces_id where c.deleted_at is null  and p.deleted_at is null order by p.name");

			return Datatables::of($lcs)

			->addColumn('action', function ($lcs){
				if ($lcs->deleted_at == null){
					return
					'<button value = "'. $lcs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $lcs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($lcs){
				if ($lcs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 2){
			$lcs = DB::select("SELECT p.name as 'province' , c.name as 'city', c.id as'id',c.deleted_at as 'deleted_at'  FROM location_provinces p INNER JOIN location_cities c ON p.id = c.provinces_id where c.deleted_at is not null  and p.deleted_at is null order by p.name");

			return Datatables::of($lcs)
			->addColumn('action', function ($lcs){
				if ($lcs->deleted_at == null){
					return
					'<button value = "'. $lcs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $lcs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($lcs){
				if ($lcs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function

	public function location_deactivated(Request $request){
		$locations;
		if ($request->filter == 0){
			$locations = DB::table('locations')
			->join('location_cities AS B', 'locations.cities_id', '=', 'B.id')
			->join('location_provinces AS C', 'B.provinces_id', '=', 'C.id')
			->select('locations.id as id','locations.deleted_at AS deleted_at', 'locations.name AS location_name', 'locations.address AS location_address', 'B.name AS city_name', 'C.name AS province_name', 'B.id AS city_id', 'C.id AS province_id', 'locations.zipCode')
			->orderBy('location_name')
			->get();

			return Datatables::of($locations)

			->addColumn('action', function ($locations){
				if ($locations->deleted_at == null){
					return
					'<button value = "'. $locations->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $locations->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($locations){
				if ($locations->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){

			$locations = DB::table('locations')
			->join('location_cities AS B', 'locations.cities_id', '=', 'B.id')
			->join('location_provinces AS C', 'B.provinces_id', '=', 'C.id')
			->select('locations.id as id','locations.deleted_at AS deleted_at',
				'locations.name AS location_name', 'locations.address AS location_address', 'B.name AS city_name', 'C.name AS province_name', 'B.id AS city_id', 'C.id AS province_id', 'locations.zipCode')
			->where('locations.deleted_at', '=', null)
			->orderBy('location_name')
			->get();


			return Datatables::of($locations)

			->addColumn('action', function ($locations){
				if ($locations->deleted_at == null){
					return
					'<button value = "'. $locations->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $locations->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($locations){
				if ($locations->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 2){
			$locations = DB::table('locations')
			->join('location_cities AS B', 'locations.cities_id', '=', 'B.id')
			->join('location_provinces AS C', 'B.provinces_id', '=', 'C.id')
			->select('locations.id as id','locations.deleted_at AS deleted_at',
				'locations.name AS location_name', 'locations.address AS location_address', 'B.name AS city_name', 'C.name AS province_name', 'B.id AS city_id', 'C.id AS province_id', 'locations.zipCode')
			->where('locations.deleted_at', '!=', null)
			->orderBy('location_name')
			->get();


			return Datatables::of($locations)
			->addColumn('action', function ($locations){
				if ($locations->deleted_at == null){
					return
					'<button value = "'. $locations->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $locations->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($locations){
				if ($locations->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function


	public function sar_deactivated(Request $request){
		$sars;
		if ($request->filter == 0){
			$sars = DB::select("select s.id , f.id as'pickup_id', l.id as 'deliver_id', l.name as 'areaTo' ,f.name as 'areaFrom' ,s.amount, s.deleted_at as 'deleted_at' from standard_area_rates s  JOIN locations as l on s.areaTo = l.id join locations as f on s.areaFrom = f.id  where l.deleted_at is null");

			return Datatables::of($sars)

			->addColumn('action', function ($sars){
				if ($sars->deleted_at == null){
					return
					'<button value = "'. $sars->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $sars->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($sars){
				if ($sars->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){

			$sars = DB::select("select s.id , f.id as'pickup_id', l.id as 'deliver_id', l.name as 'areaTo' ,f.name as 'areaFrom' ,s.amount, s.deleted_at as 'deleted_at' from standard_area_rates s  JOIN locations as l on s.areaTo = l.id join locations as f on s.areaFrom = f.id  where s.deleted_at is null and l.deleted_at is null");


			return Datatables::of($sars)

			->addColumn('action', function ($sars){
				if ($sars->deleted_at == null){
					return
					'<button value = "'. $sars->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $sars->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($sars){
				if ($sars->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 2){
			$sars = DB::select("select s.id , f.id as'pickup_id', l.id as 'deliver_id', l.name as 'areaTo' ,f.name as 'areaFrom' ,s.amount, s.deleted_at as 'deleted_at' from standard_area_rates s  JOIN locations as l on s.areaTo = l.id join locations as f on s.areaFrom = f.id  where s.deleted_at is not null and l.deleted_at is null");


			return Datatables::of($sars)
			->addColumn('action', function ($sars){
				if ($sars->deleted_at == null){
					return
					'<button value = "'. $sars->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $sars->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($sars){
				if ($sars->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function

	public function employees_deactivated(Request $request){
		$employees;
		if ($request->filter == 0){
			$employees = DB::table('employees')
			->select('id', 'firstName', 'middleName', 'lastName','created_at' ,'deleted_at')
			->get();

			return Datatables::of($employees)

			->addColumn('action', function ($employees){
				if ($employees->deleted_at == null){
					return
					'<button value = "'. $employees->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $employees->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($employees){
				if ($employees->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){

			$employees = DB::table('employees')
			->select('id', 'firstName', 'middleName', 'lastName','created_at','deleted_at')
			->where('deleted_at', '=', null)
			->get();


			return Datatables::of($employees)

			->addColumn('action', function ($employees){
				if ($employees->deleted_at == null){
					return
					'<button value = "'. $employees->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $employees->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($employees){
				if ($employees->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 2){
			$employees = DB::table('employees')
			->select('id', 'firstName', 'middleName', 'lastName','created_at','deleted_at')
			->where('deleted_at', '!=', null)
			->get();


			return Datatables::of($employees)
			->addColumn('action', function ($employees){
				if ($employees->deleted_at == null){
					return
					'<button value = "'. $employees->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $employees->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($employees){
				if ($employees->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function

	public function vr_deactivated(Request $request){
		$vrs;
		if ($request->filter == 0){
			$vrs = DB::table('vat_rates')
			->select('id',  'rate', 'dateEffective', 'created_at', 'deleted_at')
			->orderBy('deleted_at', 'desc')
			->get();


			return Datatables::of($vrs)
			->addColumn('action', function ($vrs){
				if ($vrs->deleted_at == null){
					return
					'<button value = "'. $vrs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
				}else{

					return
					'<button value = "'. $vrs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
				}
			})
			->addColumn('status', function ($vrs){
				if ($vrs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else if ($request->filter == 1){
			$vrs = DB::table('vat_rates')
			->select('id',  'rate', 'dateEffective', 'created_at', 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($vrs)
			->addColumn('action', function ($vrs){
				return
				'<button value = "'. $vrs->id.'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->addColumn('status', function ($vrs){
				if ($vrs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->editColumn('id', '{{ $id }}')
			->make(true);


		}else if ($request->filter == 2){
			$vrs = DB::table('vat_rates')
			->select('id',  'rate', 'dateEffective', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($vrs)
			->addColumn('status', function ($vrs){
				if ($vrs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($vrs){
				return
				'<button value = "'. $vrs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}//function











	public function get_contracts(Request $request)
	{
		if($request->contractFor == "0"){
			$contracts = DB::table('contract_headers')
			->select('id', 'dateEffective', 'dateExpiration')
			->where('consignees_id', '=', $request->consignee_id)
			->get();

			return Datatables::of($contracts)
			->addColumn('status', function ($contract){
				$from = Carbon::parse($contract->dateEffective);
				$to = Carbon::parse($contract->dateExpiration);

				if( Carbon::now()->between($from, $to) == true)
				{
					return 'Active';
				}
				else
				{
					return 'Expired';
				}
			})
			->addColumn('action', function ($contract){
				return
				'<input type = "hidden" value = "' .  $contract->id . '" class = "contract_header_value" />' .
				'<button value = "" class = "btn btn-md btn-success select-contract-header">Select</button>';
			})
			->editColumn('id', '{{ $id }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($dateEffective)->diffForHumans() }}')
			->editColumn('dateExpiration', '{{ Carbon\Carbon::parse($dateExpiration)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($dateExpiration)->diffForHumans() }}')
			->make(true);
		}
		else{
			$contracts = DB::table('contract_headers')
			->select('id', 'dateEffective', 'dateExpiration')
			->where('consignees_id', '=', $request->consignee_id)
			->get();

			return Datatables::of($contracts)
			->addColumn('status', function ($contract){
				$from = Carbon::parse($contract->dateEffective);
				$to = Carbon::parse($contract->dateExpiration);

				if( Carbon::now()->between($from, $to) == true)
				{
					return 'Active';
				}
				else
				{
					return 'Expired';
				}
			})
			->addColumn('action', function ($contract){
				return
				'<input type = "hidden" value = "' .  $contract->id . '" class = "contract_header_value" />' .
				'<button value = "" class = "btn btn-md btn-success select-contract-penalty">Select</button>';
			})
			->editColumn('id', '{{ $id }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($dateEffective)->diffForHumans() }}')
			->editColumn('dateExpiration', '{{ Carbon\Carbon::parse($dateExpiration)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($dateExpiration)->diffForHumans() }}')
			->make(true);
		}
	}
	public function get_contract_details(Request $request)
	{

		$contract_details = DB::table('contract_details')
		->select('A.description AS from', 'B.description AS to', 'amount', 'contract_details.id', 'A.id AS from_id', 'B.id AS to_id')
		->join('areas AS A', 'areas_id_from', '=', 'A.id')
		->join('areas AS B', 'areas_id_to', '=', 'B.id')
		->where('contract_headers_id', '=', $request->contract_id)
		->get();

		return Datatables::of($contract_details)
		->addColumn('action', function ($cd){
			return
			'<button style="text-align: center;" class = "btn btn-md btn-primary update-contract-rate">Update</button>
			<input type = "hidden" class = "selected_contract_detail" value = "' . $cd->id  .'" />
			<input type = "hidden" class = "selected_from_id" value = "' . $cd->from_id  .'" />
			<input type = "hidden" class = "selected_to_id" value = "' . $cd->to_id  .'" />
			<input type = "hidden" class = "selected_amount" value = "' . $cd->amount  .'" />
			';
		})
		->editColumn('amount', 'Php {{ $amount }}')
		->make(true);
	}

	public function brokerage_datatable(){
		$brokerages = DB::table('brokerage_service_orders')
		->select('brokerage_service_orders.id', 'companyName', 'shipper', 'freightType', 'statusType')
		->join('consignee_service_order_details', 'consigneeSODetails_id', '=', 'consignee_service_order_details.id')
		->join('consignee_service_order_headers', 'so_headers_id', '=', 'consignee_service_order_headers.id')
		->join('consignees', 'consignees_id', '=', 'consignees.id')
		->get();
		return Datatables::of($brokerages)
		->addColumn('action', function ($brokerage){
			return
			'<a href = "/brokerage/'. $brokerage->id .'/order" class = "btn btn-md but view-service-order">Manage</a>';
		})
		->editColumn('statusType', function($trucking){
			switch ($trucking->statusType) {
				case 'F':
				return 'Finished';
				break;
				case 'P':
				return 'Pending';
				break;
				case 'C':
				return 'Cancelled';
				break;
				default:
				return 'Unknown';
				break;
			}
		})
		->make(true);
	}

		public function employee_datatable(){
			$employees = DB::select("SELECT e.id, e.firstName, e.middleName, e.lastName, GROUP_CONCAT(t.name ORDER BY t.name) AS roles FROM employees e INNER JOIN employee_roles r ON e.id = r.employee_id LEFT JOIN employee_types t ON t.id = r.employee_type_id GROUP BY e.id");
			return Datatables::of($employees)
			->editColumn('firstName', '{{ $firstName . " " .$middleName . " ". $lastName }}')
			->removeColumn('middleName')
			->removeColumn('lastName')
			->addColumn('action', function ($employee){
				return
				'<a href = "/employees/'. $employee->id .'/view" class = "btn btn-md but view-service-order">Manage</a>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}

		public function get_dutiesandtaxes_table(Request $request){


			$dutiesandtaxes = DB::table('duties_and_taxes_headers')
			->select('duties_and_taxes_headers.id', 'rate', 'firstName', 'middleName', 'lastName')
			->join('employees', 'employees_id_broker', '=', 'employees.id')
			->join('exchange_rates', 'exchangeRate_id', '=', 'exchange_rates.id')
			->where('brokerageServiceOrders_id','=', $request->brokerage_id)
			->get();


			return Datatables::of($dutiesandtaxes)
			->editColumn('processedBy', '{{ $firstName . " " .$middleName . " ". $lastName }}')
			->addColumn('action', function ($dutiesandtax){
				return
				'<a href = "/brokerage/'. $dutiesandtax->id .'/view" class = "btn btn-md but view-service-order">Manage</a>';
			})

			->make(true);
		}
}
