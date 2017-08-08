<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consignee extends Model
{
    use SoftDeletes;

   	protected $fillable = [
   		'firstName',
   		'middleName',
   		'lastName', 
   		'companyName', 
   		'email', 
   		'contactNumber', 
   		'businessStyle', 
   		'TIN', 
   		'address', 
   		'city', 
   		'st_prov', 
   		'zip', 
   		'b_address', 
   		'b_city',
   		'b_st_prov',
   		'b_zip',
   	];

   	protected $dates = [
   		'deleted_at',
   	];
}
