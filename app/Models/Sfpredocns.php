<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocns extends Model
{
    protected $table = 'sfpredocns';

    public function numDomiBancPgto()
    {
        return $this->morphOne(Sfdomiciliobancario::class, 'numDomiBancPgtoable');
    }
}
