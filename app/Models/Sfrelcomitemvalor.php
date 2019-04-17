<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelcomitemvalor extends Model
{
    protected $table = 'sfrelcomitemvalor';

    public function sfrelcomitemvalorable(){
        return $this->morphTo();
    }
}
