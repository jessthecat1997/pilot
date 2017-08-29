<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderBilledRevenues extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
      'order_brokerage_id', 'bi_head_id'
    ];

    protected $dates = [
      'deleted_at',
    ];
}
