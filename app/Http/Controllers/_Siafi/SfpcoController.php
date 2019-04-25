<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpcoController extends Controller
{
    public function inserirSfpco($dado,$sfpadrao)
    {
        foreach ($dado->pco as $dpco) {
            $sfpadrao->pco()->create([
                'numSeqItem' => $dpco->numSeqItem,
                'codSit' => $dpco->codSit,
                'codUgEmpe' => $dpco->codUgEmpe,
                'indrTemContrato' => $dpco->indrTemContrato,
                'txtInscrD' => $dpco->txtInscrD,
                'numClassD' => $dpco->numClassD ?? null,
                'txtInscrE' => $dpco->txtInscrE,
                'numClassE' => $dpco->numClassE ?? null,
            ]);

            if (isset($dpco->pcoItem)) {
                $sfpcoItem = new SfpcoitemController;
                $sfpadrao = $sfpcoItem->inserirSfpcoItem($dpco,$sfpadrao);
            }

            if (isset($dpco->cronBaixaPatrimonial)) {
                $sfcronBaixaPatrimonial = new SfcronbaixapatrimonialController;
                $sfpadrao = $sfcronBaixaPatrimonial->inserirSfcronBaixaPatrimonialPco($dpco,$sfpadrao);
            }
        }

        return $sfpadrao;
    }
}
