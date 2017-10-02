<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractQuotation extends Model
{
    use SoftDeletes;

    protected $fillable = [
    'quot_head_id',
    'contract_id',
    'status',
    ];
   	protected $dates  = [
   		'deleted_at',
   	];
}
