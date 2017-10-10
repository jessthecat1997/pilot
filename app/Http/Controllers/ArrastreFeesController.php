<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ArrastreHeader;
use App\ArrastreDetail;
use App\Http\Requests\StoreArrastreFee;

class ArrastreFeesController extends Controller
{

    public function index()
    {
        $sizes = DB::table('container_types')
        ->select('id','container_types.name')
        ->where('deleted_at', '=', null)
        ->get();


        $locations = DB::table('locations')
        ->select('id', 'locations.name')
        ->where('deleted_at', '=', null)
        ->get();

        $arrastres = DB::select("SELECT DISTINCT DATEDIFF(h.dateEffective, CURRENT_DATE()) AS diff, h.id,locations.name AS location, h.dateEffective, GROUP_CONCAT(container_types.name SEPARATOR '\n' ) AS container_size, GROUP_CONCAT(CONCAT('Php ' , FORMAT(d.amount, 2)) ORDER BY d.container_sizes_id ASC SEPARATOR '\n') AS amount FROM container_types,locations,arrastre_headers h JOIN arrastre_details d ON h.id = d.arrastre_header_id WHERE container_types.id = container_sizes_id AND locations_id = locations.id AND locations.deleted_at IS NULL AND container_types.deleted_at IS NULL AND h.deleted_at IS NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");
        
        return view('admin/maintenance.arrastre_index', compact(['sizes','locations','arrastres']));
    }

    
    public function store(StoreArrastreFee $request)
    {
        $af_header = new ArrastreHeader;
        $af_header->dateEffective = $request->dateEffective;
        $af_header->locations_id = $request->locations_id;
        $af_header->save();


        $_container_sizes_id = json_decode(stripslashes($request->container_sizes_id), true);
        $_amount = json_decode(stripslashes($request->amount), true);

        $tblRowLength = $request->tblLength;

        for($x = 0; $x < $tblRowLength; $x++)
        {
            $af_detail = new ArrastreDetail;
            $af_detail->arrastre_header_id = $af_header->id;
            $af_detail->container_sizes_id = (string)$_container_sizes_id[$x];
            $af_detail->amount = (string)$_amount[$x];
            $af_detail->save();
        }


    } 
    public function update(StoreArrastreFee $request, $id)
    {

        \DB::table('arrastre_details')
        ->where('arrastre_header_id','=', $request->af_head_id)
        ->delete();
        
        $af_header= ArrastreHeader::findOrFail($id);
        $af_header->dateEffective = $request->dateEffective;
        $af_header->locations_id = $request->locations_id;
        $af_header->save();

    
        $_container_size_id = json_decode(stripslashes($request->container_size_id), true);
        $_amount = json_decode(stripslashes($request->amount), true);
        $tblRowLength = $request->tblLength;

        for($x = 0; $x < $tblRowLength; $x++)
        {
            $af_detail = new ArrastreDetail;
            $af_detail->arrastre_header_id = $af_header->id;
            $af_detail->container_sizes_id = (string)$_container_size_id[$x];
            $af_detail->amount = (string)$_amount[$x];
            $af_detail->save();
        }
    }

    public function destroy($id)
    {
        $new_af = ArrastreHeader::findOrFail($id);
        $new_af->delete();

    }

    public function af_maintain_data(Request $request){
        $rates = DB::table('arrastre_details')
        ->join ('container_types', 'container_types.id','=','container_sizes_id') 
        -> select('container_types.name AS container_size', 'amount', 'container_sizes_id')
        ->where('arrastre_header_id', '=', $request->af_id)
        ->get();

        return $rates;
    }
}
