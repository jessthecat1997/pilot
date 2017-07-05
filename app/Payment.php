<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = ['amount','so_head_id','payment_mode_id'];

    protected $dates = [
    'deleted_at',
    ];
}
