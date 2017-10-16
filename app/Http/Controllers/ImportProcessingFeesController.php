<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreIPFFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ImportProcessingFeeHeader;
use App\ImportProcessingFeeDetail;

class ImportProcessingFeesController extends Controller
{
	public function index()
	{
		$ipfs = DB::select("SELECT h.id, h.dateEffective , DATEDIFF(dateEffective, CURRENT_DATE()) AS diff, GROUP_CONCAT(CONCAT('$ ' , FORMAT (d.minimum,2) ) ORDER BY d.minimum ASC SEPARATOR '\n') AS minimum, GROUP_CONCAT(CONCAT('$ ' ,FORMAT (d.maximum,2)) ORDER BY d.minimum ASC SEPARATOR '\n') AS maximum, GROUP_CONCAT(CONCAT('Php ' ,FORMAT (d.amount,2)) SEPARATOR '\n') AS amount FROM import_processing_fee_headers h INNER JOIN import_processing_fee_details d ON h.id = d.ipf_headers_id WHERE h.deleted_at IS NULL AND d.deleted_at IS NULL GROUP BY h.id ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");


		return view('admin/maintenance.ipf_fee_index', compact(['ipfs']));
	}

	public function store(StoreIPFFee $request)
	{
		$ipf_header = new ImportProcessingFeeHeader;
		$ipf_header->dateEffective = $request->dateEffective;
		$ipf_header->save();

		$_minimum = json_decode(stripslashes($request->minimum), true);
		$_maximum = json_decode(stripslashes($request->maximum), true);
		$_amount = json_decode(stripslashes($request->amount), true);

		$tblRowLength = $request->tblLength;

		for($x = 0; $x < $tblRowLength; $x++)
		{
			$ipf_detail = new ImportProcessingFeeDetail;
			$ipf_detail->ipf_headers_id = $ipf_header->id;
			$ipf_detail->minimum = (string)$_minimum[$x];
			$ipf_detail->maximum = (string)$_maximum[$x];
			$ipf_detail->amount = (string)$_amount[$x];
			$ipf_detail->save();
		}
		return $ipf_header;


	}

	public function update(StoreIPFFee $request, $id)
	{
		$ipf = \DB::table('import_processing_fee_details')
		->where('ipf_headers_id','=', $request->ipf_head_id)
		->where('deleted_at', '=', NULL)
		->get();

		for($i = 0; $i < count($ipf); $i ++)
		{
			$del_ipf = ImportProcessingFeeDetail::findOrFail($ipf[$i]->id);
			$del_ipf->delete();
		}

		$new_ipf= ImportProcessingFeeHeader::findOrFail($id);
		$new_ipf->dateEffective = $request->dateEffective;
		$new_ipf->save();


		$_minimum = json_decode(stripslashes($request->minimum), true);
		$_maximum = json_decode(stripslashes($request->maximum), true);
		$_amount = json_decode(stripslashes($request->amount), true);


		for($x = 0; $x < count($_minimum); $x++)
		{
			$ipf_detail = new ImportProcessingFeeDetail;
			$ipf_detail->ipf_headers_id = $new_ipf->id;
			$ipf_detail->minimum = (string)$_minimum[$x];
			$ipf_detail->maximum = (string)$_maximum[$x];
			$ipf_detail->amount = (string)$_amount[$x];
			$ipf_detail->save();
		}
		return $new_ipf;
	}


	public function destroy($id)
	{

		$new_ipf = ImportProcessingFeeHeader::findOrFail($id);
		$new_ipf->delete();
	}

	public function ipf_maintain_data(Request $request){
		$rates = DB::table('import_processing_fee_details')
		->where('ipf_headers_id', '=', $request->ipf_id)
		->where('deleted_at', '=', NULL)
		->get();

		return $rates;
	}


}
