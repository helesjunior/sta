<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocob extends Model
{
    protected $table = 'sfpredocob';

    public function numDomiBancFavo()
    {
        return $this->morphOne(Sfdomiciliobancario::class, 'numDomiBancFavoable');
    }

    public function numDomiBancPgto()
    {
        return $this->morphOne(Sfdomiciliobancario::class, 'numDomiBancPgtoable');
    }
}
