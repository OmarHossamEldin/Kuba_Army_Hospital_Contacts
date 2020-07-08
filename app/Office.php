<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    public function person(){
        return $this->hasMany(Person::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    protected $guarded = [];
    protected $hidden =['user_id'];

}
