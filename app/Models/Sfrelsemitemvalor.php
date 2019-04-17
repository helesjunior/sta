<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelsemitemvalor extends Model
{
    public function sfrelsemitemvalorable(){
        return $this->morphTo();
    }
}
