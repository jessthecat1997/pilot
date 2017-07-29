<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportProcessingFeeDetail extends Model
{
	use SoftDeletes;

    protected $fillable = [
	'minimum', 'maximum', 'amount',  'import_processing_fee_headers_id', 
	];

	protected $dates = [
	'deleted_at',
	];
}
