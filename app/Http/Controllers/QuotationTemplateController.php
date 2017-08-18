<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\QuotationTerm;

class QuotationTemplateController extends Controller
{
   public function index()
	{
		$quotation = DB::table('quotation_terms')
		->select('terms', 'id')
		->where('deleted_at', '=', null)
		->get();
		return view('admin/maintenance.quotation_template_index', compact(['quotation']));
	} 

	public function update(Request $request, $id)
	{
		$quotation_template = QuotationTerm::findOrFail($id);
		$quotation_template->terms = $request->terms;
		$quotation_template->save();

		return $quotation_template;
	}
}
