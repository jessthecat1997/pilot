<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceOrderAttachment;
class ServiceOrderAttachmentsController extends Controller
{


	public function store(Request $request)
	{
		$attachment = new ServiceOrderAttachment;

		$attachment->so_head_id = $request->so_head_id;
		$attachment->req_type_id = $request->req_type_id;
		$attachment->description = $request->description;
		
		if($request->hasFile('file_path')){

			$filename = $request->file_path->getClientOriginalName();
			$request->file->storeAs('public/attachments',$filename);
			$attachment->file_path = $request->file_path;
		}

		
		$attachment->save();

		return $attachment;
	}

	public function update(Request $request, $id)
	{
		$attachment = ServiceOrderAttachment::findOrFail($id);
		$attachment->so_head_id = $request->so_head_id;
		$attachment->req_type_id = $request->req_type_id;
		$attachment->description = $request->description;
		
		if($request->hasFile('file_path')){

			$filename = $request->file_path->getClientOriginalName();
			$request->file->storeAs('public/attachments',$filename);
			$attachment->file_path = $request->file_path;
		}

		
		$attachment->save();

		return $attachment;
	}


	public function destroy($id)
	{
		$attachment = ServiceOrderAttachment::findOrFail($id);
		$attachment->delete();
	}
}
