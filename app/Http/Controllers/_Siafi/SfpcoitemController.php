<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpcoitemController extends Controller
{
    public function inserirSfpcoItem($dpco,$sfpadrao)
    {
        foreach ($dpco->pcoItem as $dpcoitem) {
            foreach ($sfpadrao->pco as $pco) {
                $pco->pcoItens()->create([
                    'numSeqItem' => $dpcoitem->numSeqItem,
                    'numEmpe' => $dpcoitem->numEmpe,
                    'codSubItemEmpe' => $dpcoitem->codSubItemEmpe ?? null,
                    'indrLiquidado' => $dpcoitem->indrLiquidado,
                    'vlr' => $dpcoitem->vlr,
                    'txtInscrA' => $dpcoitem->txtInscrA,
                    'numClassA' => $dpcoitem->numClassA ?? null,
                    'txtInscrB' => $dpcoitem->txtInscrB,
                    'numClassB' => $dpcoitem->numClassB ?? null,
                    'txtInscrC' => $dpcoitem->txtInscrC,
                    'numClassC' => $dpcoitem->numClassC ?? null,
                ]);
            }

        }
        return $sfpadrao;
    }
}
