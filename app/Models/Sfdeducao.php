<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdeducao extends Model
{
    protected $table = 'sfdeducao';


    protected $fillable = [
        'numSeqItem',
        'codSit',
        'dtVenc',
        'dtPgtoReceb',
        'codUgPgto',
        'vlr',
        'txtInscrA',
        'numClassA',
        'txtInscrB',
        'numClassB',
        'txtInscrC',
        'numClassC',
        'txtInscrD',
        'numClassD',
    ];


    public function itemRecolhimento()
    {
        return $this->morphMany(Sfitemrecolhimento::class, 'sfitemrecolhimentoable');
    }

    public function predoc()
    {
        return $this->morphOne(Sfpredoc::class, 'sfpredocable');
    }

    public function acrescimo()
    {
        return $this->morphMany(Sfacrescimo::class, 'sfacrescimoable');
    }

    public function relPcoItem()
    {
        return $this->morphMany(Sfrelcomitem::class, 'sfrelcomitemable');
    }

    public function relPsoItem()
    {
        return $this->morphMany(Sfrelcomitem::class, 'sfrelcomitemable');
    }

    public function relCredito()
    {
        return $this->morphMany(Sfrelsemitem::class, 'sfrelsemitemable');
    }
}
