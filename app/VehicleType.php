<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleType extends Model
{
	use SoftDeletes; 
	
    protected $fillable = [
    	'description',
    ];

    protected $dates = [
    	'deleted_at',
    ];
    
    public function vehicle(){
    	return $this->hasMany('App\Vehicle', 'vehicle_types_id');
    }
}
