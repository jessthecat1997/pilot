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
use App\Requirement;
use App\LclType;
use App\BasisType;
use App\DangerousCargoType;
use App\BillingInvoiceHeader;
use App\ConsigneeServiceOrderHeader;
use App\BrokerageServiceOrderDetails;
use App\CargoType;
use App\ArrastreFee;
use App\WharfageFee;
use App\Section;
use App\CategoryType;
use App\Item;
use App\ServiceOrderAttachment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatatablesController extends Controller
{
	public function vt_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$vtypes = VehicleType::select(['id', 'name','description', 'withContainer', 'created_at']);
			return Datatables::of($vtypes)
			->addColumn('action', function ($vtype) {
				return
				'<button value = "'. $vtype->id .'" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $vtype->id .'" class="btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{$id}}')
			->make(true);
		}else{
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

	public function dct_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$dcts = DangerousCargoType::select(['id', 'name', 'description', 'created_at']);

			return Datatables::of($dcts)
			->addColumn('action', function ($dct){
				return
				'<button value = "'. $dct->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $dct->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{

			$dcts = DB::table('DangerousCargoType')
			->select('id', 'name', 'description', 'created_at','deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($dcts)
			->addColumn('status', function ($dcts){
				if ($dcts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($dcts){
				return
				'<button value = "'. $dcts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);

		}
	}

	public function  bt_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$bts = BasisType::select(['id', 'name', 'abbreviation', 'created_at']);

			return Datatables::of($bts)
			->addColumn('action', function ($bt){
				return
				'<button value = "'. $bt->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $bt->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{

			
			$bts = DB::table('BasisType')
			->select('id', 'name', 'abbreviation', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($bts)
			->addColumn('status', function ($bts){
				if ($bts->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($bts){
				return
				'<button value = "'. $bts->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);


		}
	}


	public function lcl_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$lcls = LclType::select(['id', 'name', 'description', 'created_at']);

			return Datatables::of($lcls)
			->addColumn('action', function ($lcl){
				return
				'<button value = "'. $lcl->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $lcl->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{

			$lcls = DB::table('LclType')
			->select('id', 'name', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($lcls)

			->addColumn('status', function ($lcls){
				if ($lcls->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($lcls){
				return
				'<button value = "'. $lcls->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);
		}
	}

	public function req_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			
			$reqs =  DB::table('requirements')
			->select('id', 'name', 'description', 'created_at' , 'deleted_at')
			->where('deleted_at','=',null)
			->get();

			return Datatables::of($reqs)
			->addColumn('action', function ($req){
				return
				'<button value = "'. $req->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $req->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{

			$reqs =  DB::table('Requirements')
			->select('id', 'name', 'description', 'created_at' , 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($reqs)

			->addColumn('status', function ($reqs){
				if ($reqs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($reqs){
				return
				'<button value = "'. $reqs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);

		}
	}

	public function sec_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$secs = Section::select(['id', 'name', 'description', 'created_at']);

			return Datatables::of($secs)
			->addColumn('action', function ($sec){
				return
				'<button value = "'. $sec->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $sec->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{
			$secs = DB::table('sections')
			->select('id', 'name', 'description', 'created_at', 'deleted_at')
			->where('deleted_at','!=',null)
			->get();

			return Datatables::of($secs)

			->addColumn('status', function ($secs){
				if ($secs->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($secs){
				return
				'<button value = "'. $secs->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);

		}
	}
	public function atts_datatable(Request $request)
	{

		$attaches =  \DB::table('service_order_attachments')
		->select(
			'service_order_attachments.id',
			'A.name',
			'file_path',
			'service_order_attachments.description'
		)
		->join('requirements as A', 'service_order_attachments.req_type_id', '=', 'A.id')
		->where('so_head_id', '=', $request->or_id)
		->where('service_order_attachments.deleted_at', '=', null)
		->get();

		return Datatables::of($attaches)
		->addColumn('action', function ($attach){
			return
			'<button value = "'. $attach->id .'" style="margin-right:10px;" class = "btn btn-md btn-success download"><span class = "fa fa-download"></span></button>'.
			'<button value = "'. $attach->id .'" class = "btn btn-md btn-danger deactivate"><span class = "fa fa-trash"></span></button>';
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function attach_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$attaches =  DB::select("SELECT * FROM service_order_attachments where so_head_id = ?", [$request->order_id]);

			return Datatables::of($attaches)
			->addColumn('action', function ($attach){
				return
				'<button value = "'. $attach->id .'" style="margin-right:10px;" class = "btn btn-md btn-success download"><span class = "fa fa-download"></span></button>'.
				'<button value = "'. $attach->id .'" class = "btn btn-md btn-danger deactivate"><span class = "fa fa-trash"></span></button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}
		else{
			$attaches =  DB::select("SELECT * FROM service_order_attachments WHERE deleted_at is not null");
			return Datatables::of($attaches)

			->addColumn('status', function ($attaches){
				if ($attaches->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($attaches){
				return
				'<button value = "'. $attaches->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);


		}
	}

	public function cat_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$cats =  DB::select("SELECT s.name as 'section' , c.name as 'category', c.id as'id' , c.description as 'description', c.deleted_at as'deleted_at', c.created_at FROM category_types c JOIN sections s ON s.id = c.sections_id where s.deleted_at is null and c.deleted_at is null order by c.name");

			return Datatables::of($cats)
			->addColumn('action', function ($cat){
				return
				'<button value = "'. $cat->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $cat->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{

			$cats =  DB::select("SELECT s.name as 'section' , c.name as 'category', c.id as'id' , c.description as 'description', c.deleted_at as'deleted_at', c.created_at FROM category_types c JOIN sections s ON s.id = c.sections_id where s.deleted_at is null and c.deleted_at is not null order by c.name");
			return Datatables::of($cats)

			->addColumn('status', function ($cats){
				if ($cats->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($cats){
				return
				'<button value = "'. $cats->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);


		}
	}

	public function item_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$items = DB::select("SELECT i.id, s.name as 'section' , c.name as 'category', i.name as 'item', i.hsCode, i.rate, i.deleted_at as 'deleted_at', i.created_at FROM sections s , items i JOIN  category_types c ON  c.id = i.category_types_id where i.sections_id = s.id AND  s.deleted_at is null AND c.deleted_at is null AND i.deleted_at  is null  order by s.name");

			return Datatables::of($items)
			->addColumn('action', function ($item){
				return
				'<button value = "'. $item->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $item->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{
			$items = DB::select("SELECT i.id, s.name as 'section' , c.name as 'category', i.name as 'item', i.hsCode, i.rate, i.deleted_at as 'deleted_at', i.created_at FROM sections s , items i JOIN  category_types c ON  c.id = i.category_types_id where i.sections_id = s.id AND  s.deleted_at is null AND c.deleted_at is null AND i.deleted_at  is not null  order by s.name");
			return Datatables::of($items)

			->addColumn('status', function ($items){
				if ($items->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($items){
				return
				'<button value = "'. $items->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);

		}
	}

	public function ch_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$charges = Charge::select(['id', 'name', 'description','bill_type','chargeType','amount','created_at']);

			return Datatables::of($charges)
			->addColumn('action', function ($ch){
				return
				'<button value = "'. $ch->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $ch->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{

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

	public function ct_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$cts = ContainerType::select(['id', 'name','description','maxWeight', 'created_at']);

			return Datatables::of($cts)
			->addColumn('action', function ($ct){
				return
				'<button value = "'. $ct->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $ct->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);

		}else{

			$cts = DB::table('container_types')
			->select('id','name', 'description', 'created_at', 'deleted_at')
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
	}

	public function er_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$ers = DB::select("SELECT *, DATEDIFF(dateEffective, CURRENT_DATE()) AS diff FROM exchange_rates ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($ers)
			->addColumn('action', function ($er){
				return
				'<button value = "'. $er->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $er->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
				'<input type = "hidden" class = "date_effective" value = "'. Carbon::parse($er->dateEffective)->format("Y-m-d") .'">';
			})
			->editColumn('rate', 'Php {{ $rate }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->format("F d, Y") }}')
			->make(true);
		}else{

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

	public function et_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$ets = EmployeeType::select(['id', 'name', 'description', 'created_at']);

			return Datatables::of($ets)
			->addColumn('action', function ($et){
				return
				'<button value = "'. $et->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $et->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{
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
	}

	public function consignee_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){

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
		}else{

		}
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
			<input type = "hidden" value = "'. $consignee->TIN .'" class = "TIN" />
			<input type = "hidden" value = "'. $consignee->id . '" class = "consignees_id" />'
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

	public function v_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
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
		}else{

			$vs = DB::table('vehicles')
			->join('vehicle_types', 'vehicle_types_id','=', 'vehicle_types.id')
			->select('name', 'plateNumber', 'model','bodyType','dateRegistered', 'vehicles.created_at','vehicles.deleted_at')
			->where('vehicles.deleted_at', '!=', null)
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

			->editColumn('plateNumber', '{{ $plateNumber }}')
			->make(true);

		}
	}
	public function brso_head_datatable(){
		$so_heads = DB::table('consignee_service_order_headers')
		->join('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->join('consignee_service_order_details', 'consignee_service_order_details.so_headers_id', '=', 'consignee_service_order_headers.id')
		->join('service_order_types','service_order_types.id','=','consignee_service_order_details.service_order_types_id')
		->select('consignee_service_order_headers.id', 'companyName','service_order_types.name', 'consignee_service_order_details.created_at', DB::raw('CONCAT(firstName, " ", lastName) AS consignee'))
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
		$payment_hist = DB::table('payments')
		->join('billing_invoice_headers', 'payments.bi_head_id', '=', 'billing_invoice_headers.id')
		->join('consignee_service_order_headers', 'billing_invoice_headers.so_head_id', '=', 'consignee_service_order_headers.id')
		->join('consignees', 'consignee_service_order_headers.consignees_id', '=', 'consignees.id')
		->join('utility_types', 'payments.utility_id', '=', 'utility_types.id')
		->select('payments.id',DB::raw('CONCAT(firstName, " ", lastName) AS consignee'), 'amount', 'isCheque', 'payment_allowance')
		->orderBy('payments.id', 'DESC')
		->get();
		return Datatables::of($payment_hist)
		->addColumn('action', function ($hist) {
			return
			'<button value = "'. $hist->id .'" class = "btn btn-md btn-primary payment_receipt"><span class="fa fa-print"></span></button>';
		})
		->make(true);
	}
	public function pso_datatable(){
		$total = DB::select('SELECT t.id,
			CONCAT("Php ", (ROUND(((p.total * t.vatRate)/100), 2) + p.total)) as Total,
			ROUND(((p.total * t.vatRate)/100), 2) + p.total as totall,
			pay.totpay,
			(ROUND(((p.total * t.vatRate)/100), 2) + p.total) - ((pay.totpay)) AS balance,
			t.status,
			dpay.totdpay

			FROM billing_invoice_headers t LEFT JOIN
			(
			SELECT bi_head_id, SUM(amount) total
			FROM billing_invoice_details
			GROUP BY bi_head_id
			) p
			ON t.id = p.bi_head_id

			LEFT JOIN

			(
			SELECT bi_head_id, SUM(amount) totpay
			FROM payments
			GROUP BY bi_head_id
			) pay

			ON t.id = pay.bi_head_id

			LEFT JOIN
			(
			SELECT bi_head_id, SUM(amount) totdpay
			FROM deposit_payments
			GROUP BY bi_head_id
			) dpay

			ON t.id = dpay.bi_head_id
			WHERE t.status = "U" AND t.isVoid = 0 AND t.isFinalize = 1
			');

		return Datatables::of($total)
		->addColumn('action', function ($b) {
			return
			'<a href = "/payment/'. $b->id .'" style="margin-right:10px; width:100;" class = "btn btn-md but bill_inv">Select</a>';
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
			$deliveries = DB::select('SELECT CONCAT(firstName, " ", lastName) as name, companyName, B.created_at, shippingLine, portOfCfsLocation, containerVolume,  containerNumber,  DATE_FORMAT(pickupDateTime, "%M %d, %Y") as pickupDateTime, DATE_FORMAT(deliveryDateTime, "%M %d, %Y") as deliveryDateTime, B.remarks FROM  delivery_receipt_headers AS B LEFT JOIN delivery_head_containers as Y on Y.del_head_id = B.id left join delivery_containers as A on Y.container_id = A.id JOIN trucking_service_orders AS C ON B.tr_so_id = C.id JOIN consignee_service_order_details as D ON C.so_details_id = D.id JOIN consignee_service_order_headers AS E ON D.so_headers_id = E.id JOIN consignees AS F ON E.consignees_id = F.id');
			return json_encode($deliveries);
			break;

			case 2 :
			$deliveries = DB::select('SELECT CONCAT(firstName, " ", lastName) as name, companyName, B.created_at, shippingLine, portOfCfsLocation, containerVolume,  containerNumber,  DATE_FORMAT(pickupDateTime, "%M %d, %Y") as pickupDateTime, DATE_FORMAT(deliveryDateTime, "%M %d, %Y") as deliveryDateTime, DATE_FORMAT(deliveryDateTime, "%M %Y") as deliveryDateMonth, B.remarks FROM  delivery_receipt_headers AS B LEFT JOIN delivery_head_containers as Y on Y.del_head_id = B.id left join delivery_containers as A on Y.container_id = A.id JOIN trucking_service_orders AS C ON B.tr_so_id = C.id JOIN consignee_service_order_details as D ON C.so_details_id = D.id JOIN consignee_service_order_headers AS E ON D.so_headers_id = E.id JOIN consignees AS F ON E.consignees_id = F.id');
			return json_encode($deliveries);
			break;

			case 3 :
			$deliveries = DB::select('SELECT CONCAT(firstName, " ", lastName) as name, companyName, B.created_at, shippingLine, portOfCfsLocation, containerVolume,  containerNumber,  DATE_FORMAT(pickupDateTime, "%M %d, %Y") as pickupDateTime, DATE_FORMAT(deliveryDateTime, "%M %d, %Y") as deliveryDateTime, DATE_FORMAT(deliveryDateTime, "%Y") as deliveryDateYear, B.remarks FROM  delivery_receipt_headers AS B LEFT JOIN delivery_head_containers as Y on Y.del_head_id = B.id left join delivery_containers as A on Y.container_id = A.id JOIN trucking_service_orders AS C ON B.tr_so_id = C.id JOIN consignee_service_order_details as D ON C.so_details_id = D.id JOIN consignee_service_order_headers AS E ON D.so_headers_id = E.id JOIN consignees AS F ON E.consignees_id = F.id');
			return json_encode($deliveries);
			break;

			case 4 :
			$deliveries = DB::select('SELECT CONCAT(firstName, " ", lastName) as name, companyName, B.created_at, shippingLine, portOfCfsLocation, containerVolume,  containerNumber,  DATE(pickupDateTime) as pickupDateTime, DATE(deliveryDateTime) as deliveryDateTime, DATE_FORMAT(pickupDateTime, "%M %d, %Y") as dpickupDateTime, DATE_FORMAT(deliveryDateTime, "%M %d, %Y") as ddeliveryDateTime, B.remarks FROM  delivery_receipt_headers AS B LEFT JOIN delivery_head_containers as Y on Y.del_head_id = B.id left join delivery_containers as A on Y.container_id = A.id JOIN trucking_service_orders AS C ON B.tr_so_id = C.id JOIN consignee_service_order_details as D ON C.so_details_id = D.id JOIN consignee_service_order_headers AS E ON D.so_headers_id = E.id JOIN consignees AS F ON E.consignees_id = F.id WHERE DATE(deliveryDateTime) BETWEEN ? AND ?', [$request->date_from, $request->date_to]);
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

	public function lp_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){

			$lps = LocationProvince::select(['id', 'name', 'created_at']);

			return Datatables::of($lps)
			->addColumn('action', function ($lp){
				return
				'<button value = "'. $lp->id .'"   style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $lp->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{

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
	}


	public function lc_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$lcs = DB::select("SELECT p.name as 'province' , c.name as 'city', c.id as'id'  FROM location_provinces p INNER JOIN location_cities c ON p.id = c.provinces_id where c.deleted_at is null  and p.deleted_at is null order by p.name");

			return Datatables::of($lcs)
			->addColumn('action', function ($lc){
				return
				'<button value = "'. $lc->id .'" style="margin-right:10px;" class = "btn btn-md btn-info edit">Update</button>'.
				'<button value = "'. $lc->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{

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
	}




	public function bl_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$bills = Billing::select(['id', 'name', 'description', 'created_at']);

			return Datatables::of($bills)
			->addColumn('action', function ($bill){
				return
				'<button value = "'. $bill->id .'" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $bill->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{

		}
	}

	public function bf_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$bfs = DB::select("SELECT h.id, h.dateEffective, h.deleted_at , DATEDIFF(dateEffective, CURRENT_DATE()) AS diff ,
				GROUP_CONCAT(CONCAT('$ ' , FORMAT (d.minimum,2)) ORDER BY d.minimum ASC  SEPARATOR '\n') AS minimum, GROUP_CONCAT(CONCAT('$ ' , FORMAT (d.maximum,2)) ORDER BY d.minimum ASC SEPARATOR '\n') AS maximum, GROUP_CONCAT(CONCAT('Php ' , FORMAT (d.amount,2)) ORDER BY d.minimum ASC SEPARATOR '\n') AS amount FROM brokerage_fee_headers h INNER JOIN brokerage_fee_details d ON h.id = d.brokerage_fee_headers_id where h.deleted_at is null AND d.deleted_at is null GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($bfs)
			->addColumn('action', function ($bf){
				return
				'<button value = "'. $bf->id .'" style="margin-right:10px;" class = "btn btn-md btn-primary edit">Update</button>'.
				'<button value = "'. $bf->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
				'<input type = "hidden" class = "date_effective" value = "'. Carbon::parse($bf->dateEffective)->format("Y-m-d") .'">';
			})
			->editColumn('id', '{{ $id }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->format("F d, Y") }}')
			->make(true);
		}else{

			$bfs = DB::select("SELECT h.id, h.dateEffective, h.deleted_at , DATEDIFF(dateEffective, CURRENT_DATE()) AS diff ,
				GROUP_CONCAT(CONCAT('$ ' , FORMAT (d.minimum,2)) ORDER BY d.minimum ASC  SEPARATOR '\n') AS minimum, GROUP_CONCAT(CONCAT('$ ' , FORMAT (d.maximum,2)) ORDER BY d.minimum ASC SEPARATOR '\n') AS maximum, GROUP_CONCAT(CONCAT('Php ' , FORMAT (d.amount,2)) ORDER BY d.minimum ASC SEPARATOR '\n') AS amount FROM brokerage_fee_headers h INNER JOIN brokerage_fee_details d ON h.id = d.brokerage_fee_headers_id where h.deleted_at is not null AND d.deleted_at is null GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");


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
			return $contract_header->dateEffective ? with(new Carbon ($contract_header->dateEffective))->format("F d, Y") : 'Pending';
		})
		->editColumn('dateExpiration', function($contract_header){

			return $contract_header->dateExpiration ? with(new Carbon ($contract_header->dateExpiration))->format("F d, Y")  : 'Pending';



		})
		->editColumn('created_at', '{{ Carbon\Carbon::parse($created_at)->format("F d, Y") }}')
		->make(true);
	}

	public function employees_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
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
		}else{
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
	}

	public function emp_role_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
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
		}else{

		}
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
		->select('delivery_receipt_headers.id', 'plateNumber', 'delivery_receipt_headers.created_at', 'status', 'A.name AS pickup_name', 'B.name as deliver_name', 'C.name AS pickup_city', 'D.name AS deliver_city', 'delivery_receipt_headers.deliveryDateTime', 'pickupDateTime', 'amount')
		->where('delivery_receipt_headers.deleted_at', '=', null)
		->where('tr_so_id','=', $request->trucking_id)
		->get();

		return Datatables::of($deliveries)
		->addColumn('created_at_date', function($delivery){
			return
			Carbon::parse($delivery->created_at)->diffForHumans();
		})
		->editColumn('deliveryDateTime', function($deliveries){
			return Carbon::parse($deliveries->deliveryDateTime)->format('F j, Y h:i A');
		})
		->editColumn('pickupDateTime', function($deliveries){
			return Carbon::parse($deliveries->pickupDateTime)->format('F j, Y h:i A');
		})
		->addColumn('action', function ($delivery){
			if($delivery->status == 'P'){
				return
				"<button class = 'btn btn-info view_delivery' title = 'View'><span class = 'fa fa-eye'></span></button>
				<button class = 'btn btn-primary edit_delivery' title = 'Edit'><span class = 'fa fa-edit'></span></button>
				<button class = 'btn but select-delivery' data-toggle = 'modal' data-target = '#deliveryModal' title = 'Status'><span class = 'fa-flag-o fa'></span></button>" .
				"<input type = 'hidden' value = '" . $delivery->amount . "' class = 'delivery_amount' />" .
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


	public function location_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
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
		}else{

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
	}

	public function get_quotations(){
		$quotations = DB::table('quotation_headers')
		->select(DB::raw('CONCAT(firstName, " ", lastName) as name'), 'quotation_headers.id', 'quotation_headers.created_at', 'contract_headers.id as con_head', 'quotation_headers.created_at')
		->join('consignees', 'consignees_id', '=', 'consignees.id')
		->leftjoin('contract_headers', 'quotation_headers.id', '=', 'quot_head_id')
		->where('quotation_headers.deleted_at', '=', null)
		->get();

		return Datatables::of($quotations)
		->editColumn('created_at', '{{ Carbon\Carbon::parse($created_at)->format("F d, Y") }}')
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

			->editColumn('dateExpiration', '{{ Carbon\Carbon::parse($dateExpiration)->format("F d, Y") }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->format("F d, Y") }}')
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

	public function cds_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$cdss = DB::select("SELECT * , DATEDIFF(dateEffective, CURRENT_DATE()) AS diff FROM cds_fees where deleted_at is null ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($cdss)
			->addColumn('action', function ($cds){
				return
				'<button value = "'. $cds->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
				'<button value = "'. $cds->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
				'<input type = "hidden" class = "date_effective" value = "'. Carbon::parse($cds->dateEffective)->format("Y-m-d") .'">';
			})
			->editColumn('id', '{{ $id }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->format("F d, Y") }}')
			->make(true);
		}else{

			$cdss = DB::select("SELECT * , DATEDIFF(dateEffective, CURRENT_DATE()) AS diff FROM cds_fees where deleted_at is not null ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($cdss)
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
	}

	public function vr_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$vrs = VatRate::select(['id',  'rate', 'dateEffective', 'created_at']);

			return Datatables::of($vrs)
			->addColumn('action', function ($vrs){
				return
				'<button value = "'. $vrs->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
				'<button value = "'. $vrs->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
				'<input type = "hidden" class = "date_effective" value = "'. Carbon::parse($vrs->dateEffective)->format("Y-m-d") .'">';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{

		}
	}

	public function af_dc_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$arrastres = DB::select("SELECT DISTINCT h.id, h.dateEffective, DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, locations.name AS location, GROUP_CONCAT(container_types.name) AS container_size, GROUP_CONCAT(dangerous_cargo_types.name) AS dc_type, GROUP_CONCAT(CONCAT('Php ' , FORMAT(d.amount, 2)) ORDER BY d.container_sizes_id ASC SEPARATOR '\n') AS amount FROM dangerous_cargo_types, container_types,locations,arrastre_dc_headers h JOIN arrastre_dc_details d ON h.id = d.arrastre_dc_headers_id WHERE container_types.id = container_sizes_id AND dangerous_cargo_types.id = dc_types_id AND locations_id = locations.id AND locations.deleted_at IS NULL AND container_types.deleted_at IS NULL AND h.deleted_at IS NULL AND d.deleted_at IS NULL AND dangerous_cargo_types.description IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($arrastres)
			->addColumn('action', function ($arrastre){
				return
				'<button value = "'. $arrastre->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
				'<button value = "'. $arrastre->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
				'<input type = "hidden" class = "date_effective" value = "'. Carbon::parse($arrastre->dateEffective)->format("m-d-Y") .'">';
			})
			->editColumn('id', '{{ $id }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->format("F d Y") }}')
			->make(true);
			
		}else{
			$arrastres = DB::select("SELECT DISTINCT h.id, h.dateEffective, DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, locations.name AS location, GROUP_CONCAT(container_types.name) AS container_size, GROUP_CONCAT(dangerous_cargo_types.name) AS dc_type, GROUP_CONCAT(CONCAT('Php ' , FORMAT(d.amount, 2)) ORDER BY d.container_sizes_id ASC SEPARATOR '\n') AS amount FROM dangerous_cargo_types, container_types,locations,arrastre_dc_headers h JOIN arrastre_dc_details d ON h.id = d.arrastre_dc_headers_id WHERE container_types.id = container_sizes_id AND dangerous_cargo_types.id = dc_types_id AND locations_id = locations.id AND locations.deleted_at IS NULL AND container_types.deleted_at IS NULL AND h.deleted_at IS NOT NULL AND d.deleted_at IS NULL AND dangerous_cargo_types.description IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");
			return Datatables::of($arrastres)
			->addColumn('status', function ($arrastres){
				if ($arrastres->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($arrastres){
				return
				'<button value = "'. $arrastres->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);

		}
	}

	public function af_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$arrastres = DB::select("SELECT DISTINCT DATEDIFF(h.dateEffective, CURRENT_DATE()) AS diff, h.id,locations.name AS location, h.dateEffective, GROUP_CONCAT(container_types.name SEPARATOR '\n' ) AS container_size, GROUP_CONCAT(CONCAT('Php ' , FORMAT(d.amount, 2)) ORDER BY d.container_sizes_id ASC SEPARATOR '\n') AS amount FROM container_types,locations,arrastre_headers h JOIN arrastre_details d ON h.id = d.arrastre_header_id WHERE container_types.id = container_sizes_id AND locations_id = locations.id AND locations.deleted_at IS NULL AND container_types.deleted_at IS NULL AND h.deleted_at IS NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($arrastres)
			->addColumn('action', function ($arrastre){
				return
				'<button value = "'. $arrastre->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
				'<button value = "'. $arrastre->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
				'<input type = "hidden" class = "date_effective" value = "'. Carbon::parse($arrastre->dateEffective)->format("m-d-Y") .'">';
			})
			->editColumn('id', '{{ $id }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->format("F d Y") }}')
			->make(true);
		}else{

			$arrastres = DB::select("SELECT DISTINCT DATEDIFF(h.dateEffective, CURRENT_DATE()) AS diff, h.id,locations.name AS location, h.dateEffective, GROUP_CONCAT(container_types.name SEPARATOR '\n' ) AS container_size, GROUP_CONCAT(CONCAT('Php ' , FORMAT(d.amount, 2)) ORDER BY d.container_sizes_id ASC SEPARATOR '\n') AS amount FROM container_types,locations,arrastre_headers h JOIN arrastre_details d ON h.id = d.arrastre_header_id WHERE container_types.id = container_sizes_id AND locations_id = locations.id AND locations.deleted_at IS NULL AND container_types.deleted_at IS NULL AND h.deleted_at IS NOT NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($arrastres)

			->addColumn('status', function ($arrastres){
				if ($arrastres->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($arrastres){
				return
				'<button value = "'. $arrastres->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);

		}
	}

	public function wf_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$wharfages = DB::select("SELECT DISTINCT h.id,locations.name AS location, h.dateEffective,DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, GROUP_CONCAT(container_types.name ORDER BY d.container_sizes_id ASC SEPARATOR '\n') AS container_size, GROUP_CONCAT(CONCAT('Php ' , FORMAT (d.amount, 2) ) ORDER BY d.container_sizes_id ASC SEPARATOR '\n' ) AS amount FROM container_types,locations,wharfage_headers h JOIN wharfage_details d ON h.id = d.wharfage_header_id WHERE container_types.id = container_sizes_id AND locations_id = locations.id AND locations.deleted_at IS NULL AND container_types.deleted_at IS NULL AND h.deleted_at IS NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($wharfages)
			->addColumn('action', function ($wharfage){
				return
				'<button value = "'. $wharfage->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
				'<button value = "'. $wharfage->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
				'<input type = "hidden" class = "date_effective" value = "'. Carbon::parse($wharfage->dateEffective)->format("Y-m-d") .'">';
			})
			->editColumn('id', '{{ $id }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->format("F d, Y") }}')
			->make(true);
		}else{
			$wharfages = DB::select("SELECT DISTINCT h.id,locations.name AS location, h.dateEffective,DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, GROUP_CONCAT(container_types.name ORDER BY d.container_sizes_id ASC SEPARATOR '\n') AS container_size, GROUP_CONCAT(CONCAT('Php ' , FORMAT (d.amount, 2) ) ORDER BY d.container_sizes_id ASC SEPARATOR '\n' ) AS amount FROM container_types,locations,wharfage_headers h JOIN wharfage_details d ON h.id = d.wharfage_header_id WHERE container_types.id = container_sizes_id AND locations_id = locations.id AND locations.deleted_at IS NULL AND container_types.deleted_at IS NULL AND h.deleted_at IS NOT NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");
			return Datatables::of($wharfages)

			->addColumn('status', function ($wharfages){
				if ($wharfages->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($wharfages){
				return
				'<button value = "'. $wharfages->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);


		}
	}

	public function wf_lcl_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$wharfages = DB::select("SELECT DISTINCT h.id,h.dateEffective,locations.name AS location, DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, GROUP_CONCAT(basis_types.abbreviation SEPARATOR '\n') AS basis_type, GROUP_CONCAT(CONCAT('Php ' , FORMAT(d.amount ,2)) SEPARATOR '\n') AS amount FROM basis_types,locations, wharfage_lcl_headers h JOIN wharfage_lcl_details d ON h.id = d.wharfage_lcl_headers_id WHERE locations_id = locations.id AND basis_types.id = d.basis_types_id AND basis_types.deleted_at IS NULL AND locations.deleted_at IS NULL AND h.deleted_at IS NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($wharfages)
			->addColumn('action', function ($wharfage){
				return
				'<button value = "'. $wharfage->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
				'<button value = "'. $wharfage->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
				'<input type = "hidden" class = "date_effective" value = "'. Carbon::parse($wharfage->dateEffective)->format("Y-m-d") .'">';
			})
			->editColumn('id', '{{ $id }}')
			->make(true);
		}else{
			$wharfages = DB::select("SELECT DISTINCT h.id,h.dateEffective,locations.name AS location, DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, GROUP_CONCAT(basis_types.abbreviation SEPARATOR '\n') AS basis_type, GROUP_CONCAT(CONCAT('Php ' , FORMAT(d.amount ,2)) SEPARATOR '\n') AS amount FROM basis_types,locations, wharfage_lcl_headers h JOIN wharfage_lcl_details d ON h.id = d.wharfage_lcl_headers_id WHERE locations_id = locations.id AND basis_types.id = d.basis_types_id AND basis_types.deleted_at IS NULL AND locations.deleted_at IS NULL AND h.deleted_at IS NOT NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");
			return Datatables::of($wharfages)

			->addColumn('status', function ($wharfages){
				if ($wharfages->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($wharfages){
				return
				'<button value = "'. $wharfages->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);


		}
	}

	public function af_lcl_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$arrastres = DB::select("SELECT DISTINCT DATEDIFF(h.dateEffective, CURRENT_DATE()) AS diff , h.id,locations.name AS location, h.dateEffective, GROUP_CONCAT(lcl_types.name SEPARATOR '\n') AS lcl_type, GROUP_CONCAT(basis_types.abbreviation SEPARATOR '\n') AS basis_type, GROUP_CONCAT(CONCAT('Php ' , FORMAT( d.amount, 2)) SEPARATOR '\n' ) AS amount FROM lcl_types, basis_types,locations, arrastre_lcl_headers h JOIN arrastre_lcl_details d ON h.id = d.arrastre_lcl_headers_id WHERE locations_id = locations.id AND lcl_types.id = d.lcl_types_id AND basis_types.id = d.basis_types_id AND basis_types.deleted_at IS NULL AND locations.deleted_at IS NULL AND h.deleted_at IS NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($arrastres)
			->addColumn('action', function ($arrastre){
				return
				'<button value = "'. $arrastre->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
				'<button value = "'. $arrastre->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
				'<input type = "hidden" class = "date_effective" value = "'. Carbon::parse($arrastre->dateEffective)->format("Y-m-d") .'">';
			})
			->editColumn('id', '{{ $id }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->format("F d, Y") }}')
			->make(true);
		}else{
			$arrastres = DB::select("SELECT DISTINCT DATEDIFF(h.dateEffective, CURRENT_DATE()) AS diff , h.id,locations.name AS location, h.dateEffective, GROUP_CONCAT(lcl_types.name SEPARATOR '\n') AS lcl_type, GROUP_CONCAT(basis_types.abbreviation SEPARATOR '\n') AS basis_type, GROUP_CONCAT(CONCAT('Php ' , FORMAT( d.amount, 2)) SEPARATOR '\n' ) AS amount FROM lcl_types, basis_types,locations, arrastre_lcl_headers h JOIN arrastre_lcl_details d ON h.id = d.arrastre_lcl_headers_id WHERE locations_id = locations.id AND lcl_types.id = d.lcl_types_id AND basis_types.id = d.basis_types_id AND basis_types.deleted_at IS NULL AND locations.deleted_at IS NULL AND h.deleted_at IS NOT NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");
			return Datatables::of($arrastres)

			->addColumn('status', function ($arrastres){
				if ($arrastres->deleted_at == null)
				{
					return 'Active';
				}else{
					return  'Inactive';
				}

			})
			->addColumn('action', function ($arrastres){
				return
				'<button value = "'. $arrastres->id .'" class = "btn btn-md btn-success activate">Activate</button>';
			})

			->editColumn('id', '{{ $id }}')
			->make(true);

		}
	}

	public function ipf_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
			$ipfs = DB::select("SELECT h.id, h.dateEffective , DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, GROUP_CONCAT(CONCAT('$ ' , FORMAT (d.minimum,2) ) ORDER BY d.minimum ASC SEPARATOR '\n') AS minimum, GROUP_CONCAT(CONCAT('$ ' ,FORMAT (d.maximum,2)) ORDER BY d.minimum ASC SEPARATOR '\n') AS maximum, GROUP_CONCAT(CONCAT('Php ' ,FORMAT (d.amount,2)) SEPARATOR '\n') AS amount FROM import_processing_fee_headers h INNER JOIN import_processing_fee_details d ON h.id = d.ipf_headers_id WHERE h.deleted_at IS NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

			return Datatables::of($ipfs)
			->addColumn('action', function ($ipf){
				return
				'<button value = "'. $ipf->id .'" style="margin-right:10px;" class = "btn btn-md but edit">Update</button>'.
				'<button value = "'. $ipf->id .'" class = "btn btn-md btn-danger deactivate">Deactivate</button>'.
				'<input type = "hidden" class = "date_effective" value = "'. Carbon::parse($ipf->dateEffective)->format("Y-m-d") .'">';
				;
			})
			->editColumn('id', '{{ $id }}')
			->editColumn('dateEffective', '{{ Carbon\Carbon::parse($dateEffective)->format("F d, Y") }}')
			->make(true);
		}else{
			$ipfs = DB::select("SELECT h.id, h.dateEffective , DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, GROUP_CONCAT(CONCAT('$ ' , FORMAT (d.minimum,2) ) ORDER BY d.minimum ASC SEPARATOR '\n') AS minimum, GROUP_CONCAT(CONCAT('$ ' ,FORMAT (d.maximum,2)) ORDER BY d.minimum ASC SEPARATOR '\n') AS maximum, GROUP_CONCAT(CONCAT('Php ' ,FORMAT (d.amount,2)) SEPARATOR '\n') AS amount FROM import_processing_fee_headers h INNER JOIN import_processing_fee_details d ON h.id = d.ipf_headers_id WHERE h.deleted_at IS NOT NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");
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
	}


	public function sar_datatable(Request $request){
		$isActive = $request->isActive;
		if ($isActive == null){
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
		}else{
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
			"<button class = 'btn btn-info view-employee' title = 'View'><span class = 'fa fa-eye'></span></button>
			<button class = 'btn btn-primary edit-employee' title = 'Edit'><span class = 'fa fa-edit'></span></button>".
			"<input type = 'hidden' value = '" . $employee->id . "' class = 'employee-id' />";
		})
		->editColumn('id', '{{ $id }}')
		->make(true);
	}

	public function order_datatable(){

		$orders = DB::select("SELECT s.id as id, CONCAT( c.firstName, ' ', c.middleName, ' ', c.lastName ) AS consignee, c.companyName, s.created_at, CONCAT(employees.firstName, ' ', employees.lastName ) AS employee FROM consignee_service_order_headers s JOIN consignees c ON s.consignees_id = c.id JOIN employees ON s.employees_id = employees.id");
		return Datatables::of($orders)
		->addColumn('action', function ($order){
			return
			"<button class = 'btn btn-info view_order' title = 'Manage'>Manage</button>".
			"<input type = 'hidden' value = '".$order->id."' class = 'order-id' />";
		})
		->editColumn('id', '{{ $id }}')
		->make(true);

	}


	public function get_dutiesandtaxes_table(Request $request){


		$dutiesandtaxes = DB::table('duties_and_taxes_headers')
		->select('duties_and_taxes_headers.id', 'rate', 'firstName', 'middleName', 'lastName', 'brokerageFee', 'statusType')
		->join('employees', 'employees_id_broker', '=', 'employees.id')
		->join('exchange_rates', 'exchangeRate_id', '=', 'exchange_rates.id')
		->where('brokerageServiceOrders_id','=', $request->brokerage_id)
		->get();

		return Datatables::of($dutiesandtaxes)
		->editColumn('processedBy', '{{ $firstName . " " .$middleName . " ". $lastName }}')
		->editColumn('statusType', function($dutiesandtaxes){
			switch ($dutiesandtaxes->statusType) {
				case 'A':
				return 'Approved';
				break;
				case 'P':
				return 'Pending';
				break;
				case 'R':
				return 'Rejected';
				break;
				default:
				return 'Unknown';
				break;
			}})
		->addColumn('action', function ($dutiesandtax){
			return
			'<button type="button" style="margin-right:10px; width:100;" class="btn btn-md btn-info updateTax collapse in" data-toggle="modal" data-target="#updateModal" value="'. $dutiesandtax->id .'"><i class="fa fa-edit"></i>Update Status</button>
			<a href = "/brokerage/'. $dutiesandtax->id .'/view" class = "btn btn-md but view-service-order">View</a>
			<a href = "http://localhost:8000/brokerage/'.$dutiesandtax->id.'/print" class = "btn btn-md but view-service-order"> Print</a>';
		})

		->make(true);
	}
}
