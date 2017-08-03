<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consignee extends Model
{
    use SoftDeletes;

   	protected $fillable = [
   		'firstName', 'middleName', 'lastName', 'companyName', 'email', 'address', 'contactNumber', 'businessStyle', 'TIN'
   	];

   	protected $dates = [
   		'deleted_at',
   	];
}
