<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpsoitem extends Model
{
    protected $table = 'sfpsoitem';

    protected $fillable = [
        'sfpso_id',
        'numSeqItem',
        'indrLiquidado',
        'vlr',
        'codFontRecur',
        'codCtgoGasto',
        'txtInscrA',
        'numClassA',
        'txtInscrB',
        'numClassB',
        'txtInscrC',
        'numClassC',
        'txtInscrD',
        'numClassD'
    ];

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();
    }
}
