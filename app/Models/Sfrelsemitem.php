<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelsemitem extends Model
{
    protected $table = 'sfrelsemitem';

    public function sfrelsemitemable(){
        return $this->morphTo();
    }
}
