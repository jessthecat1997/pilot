<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TruckingServiceOrder extends Model
{

	protected $fillable = [
	'deliveryDate', 'status', 'so_details_id', 'bi_head_id_rev', 'bi_head_id_exp'
	];

	protected $dates = [
	'deliveryDate', 
	];

}
