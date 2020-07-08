<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    public function person(){
        return $this->belongsTo(Person::class);
    }
    protected $guarded=[];
    protected $hidden =['user_id'];

}
