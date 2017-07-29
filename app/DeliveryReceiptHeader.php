<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryReceiptHeader extends Model
{
   	use SoftDeletes;

   	protected $fillable = [
   	'emp_id_driver', 'emp_id_helper', 'deliveryAddress', 'plateNumber', 'status', 'tr_so_id', 'withContainer', 'amount', 'deliveryDateTime'
   	];

   	protected $dates = [
   	'deleted_at',
   	];
}
