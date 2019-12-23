<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    public function towns(){
        return $this->hasMany(Town::class,'wilaya_id','id');
    }
}
