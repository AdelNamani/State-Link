<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    public function wilaya(){
        return $this->belongsTo(Wilaya::class,'wilaya_id');
    }

    public function admin(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function users(){
        return $this->hasMany(User::class,'town_id');
    }
}
