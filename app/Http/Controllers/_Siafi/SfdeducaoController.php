<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfdeducaoController extends Controller
{
    public function inserirSfdeducao($deducao, $model)
    {
        $model->deducao()->create([
            'numSeqItem' => $deducao->numSeqItem,
            'codSit' => $deducao->codSit,
            'dtVenc' => $deducao->dtVenc ?? null,
            'dtPgtoReceb' => $deducao->dtPgtoReceb ?? null,
            'codUgPgto' => $deducao->codUgPgto ?? null,
            'vlr' => $deducao->vlr,
            'txtInscrA' => $deducao->txtInscrA,
            'numClassA' => $deducao->numClassA ?? null,
            'txtInscrB' => $deducao->txtInscrB,
            'numClassB' => $deducao->numClassB ?? null,
            'txtInscrC' => $deducao->txtInscrC,
            'numClassC' => $deducao->numClassC ?? null,
            'txtInscrD' => $deducao->txtInscrD,
            'numClassD' => $deducao->numClassD ?? null,
        ]);


//        if (isset($deducao->itemRecolhimento)) {
//            foreach ($deducao->itemRecolhimento as $itemRecolhimento) {
//                $sfitemrecolhimento = new SfitemrecolhimentoController;
//                $modelItemRecolhimento = $sfitemrecolhimento->inserirSfitemRecolhimentoDeducao($itemRecolhimento, $modelDeducao);
//            }
//        }
//
//        if (isset($deducao->predoc)) {
//            foreach ($deducao->predoc as $predoc) {
//                $sfpredoc = new SfpredocController;
//                $modelPreDoc = $sfpredoc->inserirSfpreDocDeducao($predoc, $modelDeducao);
//            }
//        }

        return $model;
    }


}
