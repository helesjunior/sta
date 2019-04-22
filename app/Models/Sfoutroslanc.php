<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfoutroslanc extends Model
{
    protected $table = 'sfoutroslanc';

    protected $fillable = [
        'numSeqItem',
        'codSit',
        'indrLiquidado',
        'vlr',
        'indrTemContrato',
        'txtInscrA',
        'numClassA',
        'txtInscrB',
        'numClassB',
        'txtInscrC',
        'numClassC',
        'txtInscrD',
        'numClassD',
        'tpNormalEstorno',
    ];

    public function cronBaixaPatrimonial()
    {
        return $this->morphOne(Sfcronbaixapatrimonial::class, 'sfcronbaixapatrimonialable');
    }

}
