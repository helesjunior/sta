<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpcoitem extends Model
{
    protected $table = 'sfpcoitem';

    protected $fillable = [
        'sfpco_id',
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

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();
    }

}
