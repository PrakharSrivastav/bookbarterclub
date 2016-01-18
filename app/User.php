<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at','deleted_at','notif','contact_num','mobile_num'
    ];

    public function books()
    {
        return $this->hasMany('App\Book');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

}
