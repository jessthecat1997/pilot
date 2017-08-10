<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContractTemplate;
use App\Http\Requests\StoreContractTemplate;
class ContractTemplatesController extends Controller
{
	public function index()
	{
		return view('admin/maintenance.contract_templates_index');
	}



	public function store(StoreContractTemplate $request)
	{

		$con_temp = ContractTemplate::create($request->all());
		return $con_temp;
	}

	public function update(StoreContractTemplate $request, $id)
	{
		$contract_template = ContractTemplate::findOrFail($id);
		$contract_template->name = $request->name;
		$contract_template->description = $request->description;
		$contract_template->save();

		return $contract_template;
	}


	public function destroy($id)
	{
		$contract_template = ContractTemplate::findOrFail($id);
		$contract_template->delete();

	}
}
