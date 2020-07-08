<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    protected $guarded = [];
    protected $hidden =['user_id'];

}
