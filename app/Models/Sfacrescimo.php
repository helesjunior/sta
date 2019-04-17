<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfacrescimo extends Model
{


    public function sfacrescimoable(){
        return $this->morphTo();
    }
}
