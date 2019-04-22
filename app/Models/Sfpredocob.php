<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocob extends Model
{
    protected $table = 'sfpredocob';

    protected $fillable = [
        'codTipoOB',
        'codCredorDevedor',
        'codNumLista',
        'txtCit',
        'codRecoGru',
        'codUgRaGru',
        'numRaGru',
        'codRecDarf',
        'numRefDarf',
        'codContRepas',
        'codEvntBacen',
        'codFinalidade',
        'txtCtrlOriginal',
        'vlrTaxaCambio',
        'txtProcesso',
        'codDevolucaoSPB',
    ];

    public function numDomiBancFavo()
    {
        return $this->morphOne(Sfdomiciliobancario::class, 'numDomiBancFavoable');
    }

    public function numDomiBancPgto()
    {
        return $this->morphOne(Sfdomiciliobancario::class, 'numDomiBancPgtoable');
    }
}
