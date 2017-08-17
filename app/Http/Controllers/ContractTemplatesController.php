<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContractTemplate;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreContractTemplate;
class ContractTemplatesController extends Controller
{
	public function index()
	{
		$contract = DB::table('contract_templates')
		->select('description', 'id')
		->where('deleted_at', '=', null)
		->get();
		return view('admin/maintenance.contract_templates_index', compact(['contract']));
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
