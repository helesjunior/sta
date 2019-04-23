<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpredocobController extends Controller
{
    public function inserirSfpreDocOb($predoc,$sfpadrao)
    {
        foreach ($predoc->predocOB as $predocOb) {
            foreach ($sfpadrao->deducao as $deducao) {
                $deducao->predoc->predocOb()->create([
                    'codTipoOB' => $predocOb->codTipoOB,
                    'codCredorDevedor' => $predocOb->codCredorDevedor,
                    'codNumLista' => $predocOb->codNumLista,
                    'txtCit' => $predocOb->txtCit,
                    'codRecoGru' => $predocOb->codRecoGru ?? null,
                    'codUgRaGru' => $predocOb->codUgRaGru ?? null,
                    'numRaGru' => $predocOb->numRaGru,
                    'codRecDarf' => $predocOb->codRecDarf ?? null,
                    'numRefDarf' => $predocOb->numRefDarf ?? null,
                    'codContRepas' => $predocOb->codContRepas ?? null,
                    'codEvntBacen' => $predocOb->codEvntBacen,
                    'codFinalidade' => $predocOb->codFinalidade ?? null,
                    'txtCtrlOriginal' => $predocOb->txtCtrlOriginal,
                    'vlrTaxaCambio' => $predocOb->vlrTaxaCambio ?? null,
                    'txtProcesso' => $predocOb->txtProcesso,
                    'codDevolucaoSPB' => $predocOb->codDevolucaoSPB ?? null,
                ]);
            }
        }

        return $sfpadrao;
    }
}
