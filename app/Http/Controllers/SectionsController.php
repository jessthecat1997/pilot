<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\requests\StoreSection;
use App\Section;
class SectionsController extends Controller
{
	public function index()
	{
		$section = \App\Section::all();
		return view('admin/maintenance.section_index' , compact(['section']));
	}


	public function store(StoreSection $request)
	{
		$sec = Section::create($request->all());
		return $sec;
	}

	public function update(StoreSection $request, $id)
	{
		$sec = Section::findOrFail($id);
		$sec->name = $request->name;
		$sec->description = $request->description;
		$sec->save();

		return $sec;
	}


	public function destroy($id)
	{
		$sec = Section::findOrFail($id);
		$sec->delete();
	}


	public function reactivate(Request $request)
	{
		$sec = Section::withTrashed()
		->where('id',$request->id)
		->restore();

	}
}
