<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StandardAreaRateDetails extends Model
{
   use SoftDeletes;

    protected $fillable = [
	 'amount',  'standard_area_rate_headers_id', 'areaTo','areaFrom'
	];

	protected $dates = [
	'deleted_at',
	];
}
