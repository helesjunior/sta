<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfcreditoController extends Controller
{
    public function inserirSfcredito($dado,$sfpadrao)
    {

        foreach ($dado->credito as $credito) {
            $sfpadrao->credito()->create([
                'numSeqItem' => $credito->numSeqItem,
                'codSit' => $credito->codSit,
                'indrLiquidado' => $credito->indrLiquidado ?? null,
                'vlr' => $credito->vlr,
                'codFontRecur' => $credito->codFontRecur ?? null,
                'codCtgoGasto' => $credito->codCtgoGasto,
                'txtInscrA' => $credito->txtInscrA,
                'numClassA' => $credito->numClassA ?? null,
                'txtInscrB' => $credito->txtInscrB,
                'numClassB' => $credito->numClassB ?? null,
                'txtInscrC' => $credito->txtInscrC,
                'numClassF' => $credito->numClassF ?? null,
            ]);
        }

        return $sfpadrao;
    }
}
