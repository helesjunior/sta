<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredoc extends Model
{
    protected $table = 'sfpredoc';

    public function sfpredocable(){
        return $this->morphTo();
    }
}
