<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractHeader extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'dateEffective', 'dateExpiration', 'consignees_id', 'specificDetails',
    ];

    protected $dates = [
    	'deleted_at',
    ];
}
