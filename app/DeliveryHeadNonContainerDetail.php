<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryHeadNonContainerDetail extends Model
{
	use SoftDeletes;

    protected $fillable = [
    'del_head_id',
    'non_con_id',
    ];

    protected $dates = [
    'deleted_at',
    ];
}
