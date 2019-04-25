<?php

namespace App\Http\Controllers\_Siafi;

use App\Models\Sfpadrao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfdadosbasicosController extends Controller
{
    public function inserirSfdadosBasicos(\SimpleXMLElement $dado, Sfpadrao $sfpadrao)
    {
        $sfpadrao->dadosBasicos()->create([
            'dtEmis' => $dado->dadosBasicos->dtEmis ?? null,
            'dtVenc' => $dado->dadosBasicos->dtVenc ?? null,
            'codUgPgto' => $dado->dadosBasicos->codUgPgto,
            'vlr' => $dado->dadosBasicos->vlr,
            'txtObser' => $dado->dadosBasicos->txtObser,
            'txtInfoAdic' => $dado->dadosBasicos->txtInfoAdic,
            'vlrTaxaCambio' => $dado->dadosBasicos->vlrTaxaCambio,
            'txtProcesso' => $dado->dadosBasicos->txtProcesso,
            'dtAteste' => $dado->dadosBasicos->dtAteste ?? null,
            'codCredorDevedor' => $dado->dadosBasicos->codCredorDevedor,
            'dtPgtoReceb' => $dado->dadosBasicos->dtPgtoReceb ?? null,
        ]);

        if (isset($dado->dadosBasicos->docOrigem)) {
            $sfdocOrigem = new SfdocorigemController();
            $sfpadrao = $sfdocOrigem->inserirSfdocOrigem($dado,$sfpadrao);
        }

        if (isset($dado->dadosBasicos->docRelacionado)) {
            $sfdocRelacionado = new SfdocrelacionadoController;
            $sfpadrao = $sfdocRelacionado->inserirSfdocRelacionado($dado, $sfpadrao);

        }

        if (isset($dado->dadosBasicos->tramite)) {
            $sftramite = new SftramiteController;
            $sfpadrao = $sftramite->inserirSftramite($dado, $sfpadrao);
        }

        return $sfpadrao;
    }
}
