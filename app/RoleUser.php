<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
{
    use SoftDeletes;

    protected $fillable = ['role_id','user_id'];
    protected $dates = [
    'deleted_at',
    ];
}
