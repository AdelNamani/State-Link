<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    public function votes(){
        return $this->hasMany(Vote::class,'choice_id');
    }
}
