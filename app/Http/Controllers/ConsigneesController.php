<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreConsignee;
use App\Consignee;
use DB;

class ConsigneesController extends Controller
{

	public function index(){
		$provinces = DB::table('location_provinces')
		->select('name', 'id')
		->where('deleted_at', '=', null)
		->get();

		return view('consignee.consignee_index', compact(['provinces']));
	}
	public function store(Request $request)
	{
		if($request->same_billing_address == "true"){
			$consignee = new Consignee;
			$consignee->firstName  = $request->firstName;
			$consignee->middleName = $request->middleName;
			$consignee->lastName = $request->lastName;
			$consignee->companyName = $request->companyName;
			$consignee->email = $request->email;
			$consignee->contactNumber = $request->contactNumber;
			$consignee->businessStyle = $request->businessStyle;
			$consignee->TIN = $request->TIN;
			$consignee->address = $request->address;
			$consignee->city = $request->city;
			$consignee->st_prov = $request->st_prov;
			$consignee->zip = $request->zip;
			$consignee->b_address = $request->address;
			$consignee->b_city = $request->city;
			$consignee->b_st_prov = $request->st_prov;
			$consignee->b_zip = $request->zip;

			$consignee->save();
			return $consignee;
		}
		else
		{
			$consignee = Consignee::create($request->all());
			return $consignee;
		}
		
	}

	public function get_detail(Request $request){
		$consignee = DB::table('consignees')
		->select('*')
		->where('consignees.id', '=', $request->id)
		->get();

		return $consignee;
	}

	public function get_cities(Request $request){
		$cities = DB::table('location_cities')
		->select('name', 'id')
		->where('provinces_id', '=', $request->province_id)
		->where('deleted_at', '=', null)
		->get();

		return $cities;
	}

	public function storebrok()
	{
		$cs = Consignee::create(request()->all());

		return view ('brokerage.brokerage_create');

	}

	public function update(StoreConsignee $request, $id)
	{
		$consignee = Consignee::findOrFail($id);
		$consignee->firstName = $request->firstName;
		$consignee->middleName = $request->middleName;
		$consignee->lastName = $request->lastName;
		$consignee->companyName = $request->companyName;
		$consignee->email = $request->email;
		$consignee->address = $request->address;
		$consignee->contactNumber = $request->contactNumber;
		$consignee->consigneeType = $request->consigneeType;
		$consignee->businessStyle = $request->businessStyle;
		$consignee->TIN = $request->TIN;

		$consignee->save();

		return $consignee;
	}


	public function destroy($id)
	{
		$consignee = Consignee::findOrFail($id);
		$consignee->delete();
	
	}

	public function home(){
		return view('welcome');
	}

}

