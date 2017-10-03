<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryContainerDetail extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
	'descriptionOfGoods', 'grossWeight', 'supplier', 'container_id',	
	];
	protected $dates = [
	'deleted_at',
	];
}
