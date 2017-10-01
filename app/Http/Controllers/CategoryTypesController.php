<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\requests\StoreCategoryType;
use App\CategoryType;
use DB;
class CategoryTypesController extends Controller
{
    public function index()
	{
		$category = DB::select("SELECT s.name as 'section' , c.name as 'category', c.id as'id' , c.description as 'description', c.deleted_at as'deleted_at', c.created_at FROM category_types c JOIN sections s ON s.id = c.sections_id where s.deleted_at is null and c.deleted_at is null order by c.name");
		
		$sections = \App\Section::all();

		return view('admin/maintenance.category_type_index' , compact(['category', 'sections']));
	}


	public function store(StoreCategoryType $request)
	{
		$cat = CategoryType::create($request->all());
		return $cat;
	}

	public function update(StoreCategoryType $request, $id)
	{
		$cat = CategoryType::findOrFail($id);
		$cat->name = $request->name;
		$cat->description = $request->description;
		$cat->sections_id = $request->sections_id;
		$cat->save();

		return $cat;
	}


	public function destroy($id)
	{
		$cat = CategoryType::findOrFail($id);
		$cat->delete();
	}


	public function reactivate(Request $request)
	{
		$cat = CategoryType::withTrashed()
		->where('id',$request->id)
		->restore();

	}
}
