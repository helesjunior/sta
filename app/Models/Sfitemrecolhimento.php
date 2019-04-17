<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfitemrecolhimento extends Model
{
    protected $table = 'sfitemrecolhimento';

    public function sfitemrecolhimentoable(){
        return $this->morphTo();
    }
}
