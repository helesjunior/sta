<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelsemitem extends Model
{
    public function sfrelsemitemable(){
        return $this->morphTo();
    }
}
