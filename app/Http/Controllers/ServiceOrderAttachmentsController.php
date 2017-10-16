<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceOrderAttachment;
use App\Http\Requests\StoreServiceOrderAttachments;
class ServiceOrderAttachmentsController extends Controller
{

	public function download_file(Request $request)
	{
		$attachment = ServiceOrderAttachment::findOrFail($request->attach_id);
		return response()->download(public_path('attach'). "/" . $attachment->file_path);
	}

	public function store(StoreServiceOrderAttachments $request)
	{
		$attachment = new ServiceOrderAttachment;

		$attachment->so_head_id = $request->so_head_id;
		$attachment->req_type_id = $request->req_type_id;
		$attachment->description = $request->description;
		

		if($request->file_path != null){
			$input = $request->all();
			$input['image'] = time() . '_' . $request->file_path->getClientOriginalName();
			$attachment->file_path = time() .'_' . $request->file_path->getClientOriginalName();
			$request->file_path->move(public_path('attach'), $input['image']);
			
			$attachment->save();

			$audit = new \App\AuditTrail;
			$audit->user_id = \Auth::user()->id;
			$audit->description = "Created new attachment id: " . $attachment->id;
			$audit->save();
		}

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

		$audit = new \App\AuditTrail;
		$audit->user_id = \Auth::user()->id;
		$audit->description = "Deactivated attachment id: " . $attachment->id;
		$audit->save();
	}
}
