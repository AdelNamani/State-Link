<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    public function choices(){
        return $this->hasMany(Choice::class,'survey_id');
    }
}
