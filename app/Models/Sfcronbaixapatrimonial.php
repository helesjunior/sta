<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfcronbaixapatrimonial extends Model
{
    public function sfcronbaixapatrimonialable(){
        return $this->morphTo();
    }
}
