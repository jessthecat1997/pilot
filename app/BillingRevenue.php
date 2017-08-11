<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingRevenue extends Model
{
    protected $fillable = ['bill_id','description','amount','tax','bi_head_id'];
	protected $dates = [
	'deleted_at',
	];
}
