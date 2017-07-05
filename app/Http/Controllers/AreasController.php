<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Http\Requests\StoreArea;
class AreasController extends Controller
{
    public function index()
    {
        return view('admin/maintenance.area_index');
    }


    public function store(StoreArea $request)
    {

        $ar = Area::create($request->all());
        return $ar;
    }

    public function update(StoreArea $request, $id)
    {
        $area = Area::findOrFail($id);
        $area->description = $request->description;
        $area->save();

        return $area;
    }


    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        $area->delete();

    }
}
