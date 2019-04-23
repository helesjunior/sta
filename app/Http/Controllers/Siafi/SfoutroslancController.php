<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfoutroslancController extends Controller
{
    public function inserirSfoutrosLanc($dado,$sfpadrao)
    {
        foreach ($dado->outrosLanc as $outrosLanc) {
            $sfpadrao->outrosLanc()->create([
                'numSeqItem' => $outrosLanc->numSeqItem,
                'codSit' => $outrosLanc->codSit,
                'indrLiquidado' => $outrosLanc->indrLiquidado ?? null,
                'vlr' => $outrosLanc->vlr,
                'indrTemContrato' => $outrosLanc->indrTemContrato ?? null,
                'txtInscrA' => $outrosLanc->txtInscrA,
                'numClassA' => $outrosLanc->numClassA ?? null,
                'txtInscrB' => $outrosLanc->txtInscrB,
                'numClassB' => $outrosLanc->numClassB ?? null,
                'txtInscrC' => $outrosLanc->txtInscrC,
                'numClassC' => $outrosLanc->numClassC ?? null,
                'txtInscrD' => $outrosLanc->txtInscrD,
                'numClassD' => $outrosLanc->numClassD ?? null,
                'tpNormalEstorno' => $outrosLanc->tpNormalEstorno,
            ]);


            if (isset($outrosLanc->cronBaixaPatrimonial)) {
                $sfcronBaixaPatrimonial = new SfcronbaixapatrimonialController;
                $sfpadrao = $sfcronBaixaPatrimonial->inserirSfcronBaixaPatrimonialOutrosLanc($outrosLanc,$sfpadrao);
            }


        }





        return $sfpadrao;
    }
}
