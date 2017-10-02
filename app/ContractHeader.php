<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractHeader extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'dateEffective', 'dateExpiration', 'consignees_id', 'specificDetails','isFinalize', 'quot_head_id'
    ];

    protected $dates = [
    	'deleted_at',
    ];
}
