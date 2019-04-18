<?php

namespace App\Http\Controllers\Siafi;

use App\Models\Sfpadrao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpadraoController extends Controller
{
    public function buscaSfpadrao($dado)
    {
        $sfpadrao = Sfpadrao::where('codUgEmit', $dado->codUgEmit)
            ->where('anoDH', $dado->anoDH)
            ->where('codTipoDH', $dado->codTipoDH)
            ->where('numDH', $dado->numDH)
            ->first();;

        return $sfpadrao;

    }

    public function inserirSfpadrao($dado)
    {
        $sfpadrao = new Sfpadrao;

        $sfpadrao->codUgEmit = $dado->codUgEmit;
        $sfpadrao->anoDH = $dado->anoDH;
        $sfpadrao->codTipoDH = $dado->codTipoDH;
        $sfpadrao->numDH = $dado->numDH;
        $sfpadrao->save();


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
            foreach ($dado->dadosBasicos->docOrigem as $docorigem) {
                $sfpadrao->dadosBasicos->docOrigem()->create([
                    'codIdentEmit' => $docorigem->codIdentEmit,
                    'dtEmis' => $docorigem->dtEmis ?? null,
                    'numDocOrigem' => $docorigem->numDocOrigem,
                    'vlr' => $docorigem->vlr,
                ]);
            }
        }

        if (isset($dado->dadosBasicos->docRelacionado)) {
            foreach ($dado->dadosBasicos->docRelacionado as $docrelacionado) {
                $sfpadrao->dadosBasicos->docRelacionado()->create([
                    'codUgEmit' => $docrelacionado->codUgEmit,
                    'numDocRelacionado' => $docrelacionado->numDocRelacionado,
                ]);
            }
        }

        if (isset($dado->dadosBasicos->tramite)) {
            foreach ($dado->dadosBasicos->tramite as $tramite) {
                $sfpadrao->dadosBasicos->docRelacionado()->create([
                    'txtLocal' => $tramite->txtLocal,
                    'dtEntrada' => $tramite->dtEntrada,
                    'DtSaida' => $tramite->DtSaida,
                ]);
            }
        }

        return $sfpadrao;

    }

    public function atualizaSfpadrao($dado)
    {
        $sfpadrao = new Sfpadrao;

        $sfpadrao->codUgEmit = $dado->codUgEmit;
        $sfpadrao->anoDH = $dado->anoDH;
        $sfpadrao->codTipoDH = $dado->codTipoDH;
        $sfpadrao->numDH = $dado->numDH;
        $sfpadrao->save();

        return $sfpadrao;

    }
}
