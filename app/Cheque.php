<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cheque extends Model
{
     use SoftDeletes;

    protected $fillable = ['chequeNumber','bankName','amount','isVerify', 'bi_head_id'];

    protected $dates = [
    'deleted_at',
    ];
}
