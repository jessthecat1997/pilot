<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = ['amount','isCheque','so_head_id'];

    protected $dates = [
    'deleted_at',
    ];
}
