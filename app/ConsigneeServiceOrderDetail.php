<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsigneeServiceOrderDetail extends Model
{
	protected $fillable = [
	'so_headers_id', 'service_order_types_id'
	];

}
