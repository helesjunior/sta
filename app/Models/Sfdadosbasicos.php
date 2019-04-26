<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdadosbasicos extends Model
{
    protected $table = 'sfdadosbasicos';

    protected $fillable = [
        'sfpadrao_id',
        'dtEmis',
        'dtVenc',
        'codUgPgto',
        'vlr',
        'txtObser',
        'txtInfoAdic',
        'vlrTaxaCambio',
        'txtProcesso',
        'dtAteste',
        'codCredorDevedor',
        'dtPgtoReceb',
    ];

    public function createFromXml(array $dado)
    {

        $this->fill($dado);
        $this->save();

        $this->createDocOrigemFromXml($dado);
        $this->createDocRelacionadoFromXml($dado);
        $this->createTramiteFromXml($dado);

        return $this;
    }

    private function createDocOrigemFromXml(array $dado)
    {
        if (!isset($dado['docOrigem'])) {
            return;
        }

        $docsorigem = isset($dado['docOrigem'][0]) ? $dado['docOrigem'] : [$dado['docOrigem']];

        foreach ($docsorigem as $docorigem) {
            $docorigem['sfdadosbasicos_id'] = $this->id;
            $sfdocorigem = new Sfdocorigem;
            $sfdocorigem->createFromXml($docorigem);
        }

    }

    private function createDocRelacionadoFromXml(array $dado)
    {
        if (!isset($dado['docRelacionado'])) {
            return;
        }

        $docsRelacionado = isset($dado['docRelacionado'][0]) ? $dado['docRelacionado'] : [$dado['docRelacionado']];

        foreach ($docsRelacionado as $docRelacionado) {
            $docRelacionado['sfdadosbasicos_id'] = $this->id;
            $sfdocRelacionado = new Sfdocrelacionado;
            $sfdocRelacionado->createFromXml($docRelacionado);
        }

    }

    private function createTramiteFromXml(array $dado)
    {
        if (!isset($dado['tramite'])) {
            return;
        }

        $tramites = isset($dado['tramite'][0]) ? $dado['tramite'] : [$dado['tramite']];

        foreach ($tramites as $tramite) {
            $tramite['sfdadosbasicos_id'] = $this->id;
            $sftramite = new Sftramite;
            $sftramite->createFromXml($tramite);
        }

    }


    public function docOrigem()
    {
        return $this->hasMany(Sfdocorigem::class);
    }

    public function docRelacionado()
    {
        return $this->hasMany(Sfdocrelacionado::class);
    }

    public function tramite()
    {
        return $this->hasMany(Sftramite::class);
    }
}
