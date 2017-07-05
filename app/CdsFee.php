<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CdsFee extends Model
{
    use SoftDeletes;

   	protected $fillable = [
   		'fee', 'currentFee', 'dateEffective',
   	];

   	protected $dates = [
   		'deleted_at',
   	];
}
