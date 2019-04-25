<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpsoitemController extends Controller
{
    public function inserirSfpsoItem($pso,$sfpadrao)
    {
        foreach ($pso->psoItem as $psoitem) {
            foreach ($sfpadrao->pso as $pso) {
                $pso->psoItens()->create([
                    'numSeqItem' => $psoitem->numSeqItem,
                    'indrLiquidado' => $psoitem->indrLiquidado ?? null,
                    'vlr' => $psoitem->vlr,
                    'codFontRecur' => $psoitem->codFontRecur ?? null,
                    'codCtgoGasto' => $psoitem->codCtgoGasto,
                    'txtInscrA' => $psoitem->txtInscrA,
                    'numClassA' => $psoitem->numClassA ?? null,
                    'txtInscrB' => $psoitem->txtInscrB,
                    'numClassB' => $psoitem->numClassB ?? null,
                    'txtInscrC' => $psoitem->txtInscrC,
                    'numClassC' => $psoitem->numClassC ?? null,
                    'txtInscrD' => $psoitem->txtInscrD,
                    'numClassD' => $psoitem->numClassD ?? null,
                ]);
            }
        }

        return $sfpadrao;
    }
}
