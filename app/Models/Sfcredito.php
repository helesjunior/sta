<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfcredito extends Model
{
    protected $table = 'sfcredito';

    protected $fillable = [
        'numSeqItem',
        'codSit',
        'indrLiquidado',
        'vlr',
        'codFontRecur',
        'codCtgoGasto',
        'txtInscrA',
        'numClassA',
        'txtInscrB',
        'numClassB',
        'txtInscrC',
    ];

}
