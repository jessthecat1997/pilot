<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrokerageFeeDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
	'minimum', 'maximum', 'amount',  'brokerage_fee_headers_id', 
	];

	protected $dates = [
	'deleted_at',
	];
}
