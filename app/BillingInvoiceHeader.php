<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BillingInvoiceHeader extends Model
{
	use SoftDeletes;
	
	
	protected $fillable = ['isRevenue','isFinalize','isVatFree','isVoid','vatRate','status', 'so_head_id'];
	protected $dates = [
    	'deleted_at',
    ];
}
