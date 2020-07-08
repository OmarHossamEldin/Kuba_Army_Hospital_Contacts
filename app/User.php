<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'username', 'password','role'
    ];

    protected $hidden = [
        'password'
    ];

}
