<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfcronbaixapatrimonial extends Model
{
    protected $table = 'sfcronbaixapatrimonial';

    public function sfcronbaixapatrimonialable(){
        return $this->morphTo();
    }
}
