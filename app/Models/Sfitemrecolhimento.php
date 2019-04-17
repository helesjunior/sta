<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfitemrecolhimento extends Model
{
    public function sfitemrecolhimentoable(){
        $this->morphTo();
    }
}
