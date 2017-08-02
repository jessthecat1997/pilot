<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreConsignee;
use App\Consignee;

class ConsigneesController extends Controller
{

	public function index(){
		return view('consignee.consignee_index');
	}
	public function store(StoreConsignee $request)
	{

		$cs = Consignee::create($request->all());
		return $cs;
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
