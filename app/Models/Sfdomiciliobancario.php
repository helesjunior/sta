<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdomiciliobancario extends Model
{
    protected $table = 'sfdomiciliobancario';

    protected $fillable = [
        'banco',
        'agencia',
        'conta'
    ];

    public function numDomiBancFavoable()
    {
        $this->morphTo();
    }

    public function numDomiBancPgtoable()
    {
        $this->morphTo();
    }

}
