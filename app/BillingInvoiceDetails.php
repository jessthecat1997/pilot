<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BillingInvoiceDetails extends Model
{
	use SoftDeletes;
	
	
	protected $fillable = ['charge_id','amount','tax','bi_head_id'];
	protected $dates = [
	'deleted_at',
	];
}
