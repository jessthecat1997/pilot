<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryBilling extends Model
{
	protected $fillable = [
		'charges_id', 'amount', 'isBilled', 'isBilledTo', 'remarks', 'del_head_id',
	];
}
