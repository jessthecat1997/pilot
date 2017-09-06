<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ArrastreFeeHeader;
use App\ArrastreFeeDetail;

class ArrastreFeesController extends Controller
{

    public function index()
    {
        $sizes = \App\ContainerType::all();
        $locations = DB::table('locations')
        ->select('id', 'locations.name')
        ->where('deleted_at', '=', null)
        ->get();
        return view('admin/maintenance.arrastre_index', compact(['sizes','locations']));
    }

    
    public function create()
    {
      
    }

   
    
    public function update(Request $request, $id)
    {
      
    }

    public function destroy($id)
    {
       
    }

    public function af_maintain_data(Request $request){
        $rates = DB::table('arrastre_details')
        ->where('arrastre_headers_id', '=', $request->arrastre_id)
        ->get();

        return $rates;
    }
}
