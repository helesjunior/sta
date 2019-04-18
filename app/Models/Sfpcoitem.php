<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpcoitem extends Model
{
    protected $table = 'sfpcoitem';

    protected $fillable = [
        'numSeqItem',
        'numEmpe',
        'codSubItemEmpe',
        'indrLiquidado',
        'vlr',
        'txtInscrA',
        'numClassA',
        'txtInscrB',
        'numClassB',
        'txtInscrC',
        'numClassC'
    ];

}
