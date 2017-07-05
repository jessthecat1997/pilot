<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BillingInvoiceDetails extends Model
{
	use SoftDeletes;
	
	
	protected $fillable = ['billings_id','amount','discount','bi_head_id'];
	protected $dates = [
	'deleted_at',
	];
}
