<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryContainerDetail extends Model
{
	protected $fillable = [
	'descriptionOfGoods', 'grossWeight', 'supplier', 'container_id',	
	];
	public $timestamps = false;
}
