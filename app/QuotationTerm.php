<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationTerm extends Model
{
	use SoftDeletes;

	protected $fillable = [
	'terms',
	];

	protected $dates = [
	'deleted_at',
	];
    
}
