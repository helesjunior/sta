<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelcomitem extends Model
{
    public function sfrelcomitemable(){
        return $this->morphTo();
    }
}
