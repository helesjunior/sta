<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfacrescimo extends Model
{

    protected $table = 'sfacrescimo';

    public function sfacrescimoable(){
        return $this->morphTo();
    }
}
