<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
  use Notifiable;
  use softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'name', 'email', 'password', 'emp_id', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'password', 'remember_token',
    ];
    protected $dates = [
    'deleted_at',
    ];

    public function employee(){
        return $this->hasOne('App\Employee');
    }
    public function roles(){
        return $this->belongsTo('App\EmployeeType');
    }

}
