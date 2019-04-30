<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocob extends Model
{
    protected $table = 'sfpredocob';

    protected $fillable = [
        'sfpredoc_id',
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

    public function createFromXML(array $predocob)
    {
        $this->fill($predocob);
        $this->save();

        $this->createnumDomiBancFavoFromXml($predocob);
        $this->createnumDomiBancPgtoFromXml($predocob);

        return $this;
    }

    private function createnumDomiBancFavoFromXml(array $dado)
    {
        if (!isset($dado['numDomiBancFavo'])) {
            return;
        }
        $domiciliobancario = $dado['numDomiBancFavo'];

        $domiciliobancario['morphfav'] = $this;
        $sfdomicilio = new Sfdomiciliobancario;
        $sfdomicilio->createFromXml($domiciliobancario);

    }

    private function createnumDomiBancPgtoFromXml(array $dado)
    {
        if (!isset($dado['numDomiBancPgto'])) {
            return;
        }
        $domiciliobancario = $dado['numDomiBancPgto'];

        $domiciliobancario['morphpgto'] = $this;
        $sfdomicilio = new Sfdomiciliobancario;
        $sfdomicilio->createFromXml($domiciliobancario);

    }

    public function deleteDomicilioBancarioFav($dado){
        if(isset($dado->numdomibancfavo)){
            $dado->numdomibancfavo->delete();
        }
    }

    public function deleteDomicilioBancarioPgto($dado){
        if(isset($dado->numdomibancpgto)){
            $dado->numdomibancpgto->delete();
        }
    }

    public function numdomibancfavo()
    {
        return $this->morphOne(Sfdomiciliobancario::class, 'numdomibancfavoable');
    }

    public function numdomibancpgto()
    {
        return $this->morphOne(Sfdomiciliobancario::class, 'numdomibancpgtoable');
    }
}
