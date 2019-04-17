<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelcomitem extends Model
{
    protected $table = 'sfrelcomitem';

    public function sfrelcomitemable(){
        return $this->morphTo();
    }
}
