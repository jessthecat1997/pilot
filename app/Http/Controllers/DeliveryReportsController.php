<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
class DeliveryReportsController extends Controller
{
	public function index()
	{
		$current = \Carbon\Carbon::now('Asia/Hong_Kong');
		$now = \Carbon\Carbon::now('Asia/Hong_Kong')->format('m/d/Y');
		return view ('reports.delivery_report', compact(['now', 'current']));
	}

	public function delivery_pdf_report(Request $request)
	{
		if($request->blank == 1)
		{
			$pdf = PDF::loadView('reports.blank_pdf');
			$pdf->setPaper('A4', 'landscape');
			return $pdf->stream();
		}
		else
		{

			$utility = \App\UtilityType::all();	

			$status_filter = "";
			switch ($request->status) {
				case '0':
					$status_filter =  'AND B.status IN ("P", "F", "C") ';
					break;
				case '1':
					$status_filter =  'AND B.status IN ("P") ';
					break;
				case '2':
					$status_filter =  'AND B.status IN ("F") ';
					break;
				case '3':
					$status_filter =  'AND B.status IN ("C") ';
				default:
					# code...
					break;
			}
			
			$deliveries = \DB::select('SELECT CONCAT(firstName, " ", lastName) as name, companyName, B.created_at, shippingLine, portOfCfsLocation, containerVolume,  containerNumber,  DATE(pickupDateTime) as pickupDateTime, DATE(deliveryDateTime) as deliveryDateTime, DATE_FORMAT(pickupDateTime, "%M %d, %Y") as dpickupDateTime, DATE_FORMAT(deliveryDateTime, "%M %d, %Y") as ddeliveryDateTime, B.remarks, B.status FROM  delivery_receipt_headers AS B LEFT JOIN delivery_head_containers as Y on Y.del_head_id = B.id left join delivery_containers as A on Y.container_id = A.id JOIN trucking_service_orders AS C ON B.tr_so_id = C.id JOIN consignee_service_order_details as D ON C.so_details_id = D.id JOIN consignee_service_order_headers AS E ON D.so_headers_id = E.id JOIN consignees AS F ON E.consignees_id = F.id WHERE DATE(B.pickupDateTime) BETWEEN ? AND ? ' . $status_filter , [\Carbon\Carbon::createFromFormat("Y-m-d", $request->date_from)->format("Y-m-d"), \Carbon\Carbon::createFromFormat("Y-m-d", $request->date_to)->format("Y-m-d")]);

			$pdf = PDF::loadView('reports.delivery_pdf', compact(['deliveries', 'utility']));
			$pdf->setPaper('A4', 'landscape');
			return $pdf->stream();
		}
	}

	public function pdfview(Request $request){
		$users = \DB::table("users")->get();
		view()->share('users',$users);

		if($request->has('download')) {
        	// pass view file
			$pdf = PDF::loadView('reports.pdfview');
            // download pdf
			return $pdf->download('userlist.pdf');
		}
		return view('reports.pdfview');
	}
}
