<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\requests\StoreItem;
use App\Item;
use DB;
class ItemsController extends Controller
{
	public function index()
	{
		$items = DB::select("SELECT i.id, s.name as 'section' , c.name as 'category', i.name as 'item', i.hsCode, i.rate, i.deleted_at as 'deleted_at', i.created_at FROM sections s , items i JOIN category_types c ON c.id = i.category_types_id where c.sections_id = s.id AND s.deleted_at is null AND c.deleted_at is null AND i.deleted_at is null order by s.name");

		$sections = \App\Section::all();
		$category = \App\CategoryType::all();

		return view('admin/maintenance.item_index' , compact(['items','category', 'sections']));
	}


	public function store(StoreItem $request)
	{
		$item = Item::create($request->all());
		return $item;
	}

	public function update(StoreItem $request, $id)
	{
		$item = Item::findOrFail($id);
		$item->category_types_id = $request->category_types_id;
		$item->name = $request->name;
		$item->hsCode = $request->hsCode;
		$item->rate = $request->rate;
		$item->save();

		return $item;
	}


	public function destroy($id)
	{
		$item = Item::findOrFail($id);
		$item->delete();
	}

	public function get_categories(Request $request){
		$category = DB::table('category_types')
		->select('name', 'id')
		->where('sections_id', '=', $request->sections_id)
		->where('deleted_at', '=', null)
		->get();

		return $category;
	}


	public function reactivate(Request $request)
	{
		$item = Item::withTrashed()
		->where('id',$request->id)
		->restore();

	}
}
