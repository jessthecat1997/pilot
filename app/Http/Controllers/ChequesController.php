<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChequesController extends Controller
{
	public function update(Request $request, $id)
	{
		$chq = Cheque::findOrFail($id);
		$chq->isVerify = $request->isVerify;
		$chq->save();

		return $csh;
	}
}
