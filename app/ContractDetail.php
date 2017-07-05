<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractDetail extends Model
{
	use SoftDeletes;

	protected $fillable = [
	'areas_id_from', 'areas_id_to', 'amount', 'currentRate', 'contract_headers_id', 
	];

	protected $dates = [
	'deleted_at',
	];
}
