<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredoc extends Model
{
    public function sfpredocable(){
        return $this->morphTo();
    }
}
