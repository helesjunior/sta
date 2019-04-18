<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdomiciliobancario extends Model
{
    protected $table = 'sfdomiciliobancario';

    public function numDomiBancFavoable()
    {
        $this->morphTo();
    }

    public function numDomiBancPgtoable()
    {
        $this->morphTo();
    }

}
