<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRequirements;
use App\Requirement;


class RequirementsController extends Controller
{

  public function index()
  {
    $reqs = \App\Requirement::all();

    return view('admin/maintenance.requirement_index', compact(["reqs"]));
  }


  public function store(StoreRequirements $request)
  {
    $req = Requirement::create($request->all());
    return $req;
  }

  public function update(StoreRequirements $request, $id)
  {
   $req = Requirement::findOrFail($id);
   $req->name = $request->name;
   $req->description = $request->description;
   $req->save();

   return $req;
 }


 public function destroy($id)
 {
  $req = Requirement::findOrFail($id);
  $req->delete();
}


public function reactivate(Request $request)
{
  $req = Requirement::withTrashed()
  ->where('id',$request->id)
  ->restore();

}


}
