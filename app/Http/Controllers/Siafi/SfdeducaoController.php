<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfdeducaoController extends Controller
{
    public function inserirSfdeducao($dado,$sfpadrao)
    {
        foreach ($dado->deducao as $deducao) {

                $sfpadrao->deducao()->create([
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

                if (isset($deducao->itemRecolhimento)) {
                    $sfitemrecolhimento = new SfitemrecolhimentoController;
                    $sfpadrao = $sfitemrecolhimento->inserirSfitemRecolhimentoDeducao($deducao,$sfpadrao);
                }

//                if($deducao->vlr == '238.10'){
//                    dd($deducao, $sfpadrao->deducao);
//                }

                if (isset($deducao->predoc)) {
                    $sfpredoc = new SfpredocController;
                    $sfpadrao = $sfpredoc->inserirSfpreDocDeducao($deducao,$sfpadrao);
                }

        }

        return $sfpadrao;
    }
}
