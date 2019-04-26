<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfacrescimo extends Model
{

    protected $table = 'sfacrescimo';

    protected $fillable = [
        'tpAcrescimo',
        'vlr',
        'numEmpe',
        'codSubItemEmpe',
        'codFontRecur',
        'codCtgoGasto',
        'txtInscrA',
        'numClassA',
        'txtInscrB',
        'numClassB',
    ];

    public function createFromXML(array $dado)
    {
        $this->fill($dado);
        $this->sfacrescimoable()->associate($dado['morph']);
        $this->save();


        return $this;
    }


    public function sfacrescimoable()
    {
        return $this->morphTo();
    }
}
