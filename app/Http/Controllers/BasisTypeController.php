<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBasisType;
use App\BasisType;

class BasisTypeController extends Controller
{
    public function index()
    {
         $basis_type = \App\BasisType::all();
        return view('admin/maintenance.basis_type_index', compact(['basis_type']));
    }


    public function store(StoreBasisType $request)
    {
        $bt = BasisType::create($request->all());
        return $bt;
    }

    public function update(StoreBasisType $request, $id)
    {
        $bt = BasisType::findOrFail($id);
        $bt->name = $request->name;
        $bt->abbreviation = $request->abbreviation;
        $bt->save();

        return $bt;
    }


    public function destroy($id)
    {
        $bt = BasisType::findOrFail($id);
        $bt->delete();
    }

    public function reactivate(Request $request)
    {
        $bt = BasisType::withTrashed()
        ->where('id',$request->id)
        ->restore();

    }

    public function basis_type_utilities(){

       // return view('admin/utilities.basis_types_utility_index');
    }
}
