<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelsemitemvalor extends Model
{
    protected $table = 'sfrelsemitemvalor';

    public function sfrelsemitemvalorable(){
        return $this->morphTo();
    }
}
