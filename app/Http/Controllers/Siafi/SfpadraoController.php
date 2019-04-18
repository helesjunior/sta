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

    /**
     * @param $dado
     * @return Sfpadrao
     */
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

        if (isset($dado->pco)) {
            foreach ($dado->pco as $pco) {
                $sfpadrao->pco()->create([
                    'numSeqItem' => $pco->numSeqItem,
                    'codSit' => $pco->codSit,
                    'codUgEmpe' => $pco->codUgEmpe,
                    'indrTemContrato' => $pco->indrTemContrato,
                    'txtInscrD' => $pco->txtInscrD,
                    'numClassD' => $pco->numClassD ?? 0,
                    'txtInscrE' => $pco->txtInscrE,
                    'numClassE' => $pco->numClassE ?? 0,
                ]);
            }
        }

        if (isset($dado->pco->pcoItem)) {
            foreach ($dado->pco->pcoItem as $pcoitem) {
                $sfpadrao->pco->pcoItem()->create([
                    'numSeqItem' => $pcoitem->numSeqItem,
                    'numEmpe' => $pcoitem->numEmpe,
                    'codSubItemEmpe' => $pcoitem->codSubItemEmpe ?? 0,
                    'indrLiquidado' => $pcoitem->indrLiquidado,
                    'vlr' => $pcoitem->vlr,
                    'txtInscrA' => $pcoitem->txtInscrA,
                    'numClassA' => $pcoitem->numClassA ?? 0,
                    'txtInscrB' => $pcoitem->txtInscrB,
                    'numClassB' => $pcoitem->numClassB ?? 0,
                    'txtInscrC' => $pcoitem->txtInscrC,
                    'numClassC' => $pcoitem->numClassC ?? 0,
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
