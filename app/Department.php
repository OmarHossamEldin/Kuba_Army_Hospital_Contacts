<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function office(){
        return $this->hasMany(Office::class);
    }

    protected $guarded = [];
    protected $hidden =['user_id'];
}
