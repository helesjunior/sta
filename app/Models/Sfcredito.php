<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfcredito extends Model
{
    protected $table = 'sfcredito';

    protected $fillable = [
        'sfpadrao_id',
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

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();

        return $this;
    }

}
