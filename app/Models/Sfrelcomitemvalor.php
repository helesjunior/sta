<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelcomitemvalor extends Model
{
    public function sfrelcomitemvalorable(){
        return $this->morphTo();
    }
}
