<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DeliveryNonContainerDetail extends Model
{
	use SoftDeletes;
	
    protected $fillable = [
    'descriptionOfGoods', 'grossWeight', 'supplier', 'del_head_id',	
    ];

    protected $dates = [
    'deleted_at',
    ];
}
