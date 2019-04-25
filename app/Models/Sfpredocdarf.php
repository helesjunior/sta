<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocdarf extends Model
{
    protected $table = 'sfpredocdarf';

    protected $fillable = [
        'sfpredoc_id',
        'codTipoDARF',
        'codRecurso',
        'dtPrdoApuracao',
        'numRef',
        'txtProcesso',
        'vlrRctaBrutaAcum',
        'vlrPercentual',
        'numCodBarras',
        'vinculacaoPgto',
    ];


    public function createFromXML(array $predocdarf)
    {
        $this->fill($predocdarf);
        $this->save();

        return $this;
    }

}
