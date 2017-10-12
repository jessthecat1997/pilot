<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ServiceOrderAttachment extends Model
{
	use SoftDeletes;

   	protected $fillable = [
   		'so_head_id', 'file_path', 'req_type_id', 'description',
   	];

   	protected $dates = [
   		'deleted_at',
   	];
}
