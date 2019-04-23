<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfparcelaController extends Controller
{
    public function inserirSfparcelaPco($dcronBaixaPatrimonial,$sfpadrao)
    {
        foreach ($dcronBaixaPatrimonial->parcela as $dparcela) {
            foreach ($sfpadrao->pco as $pco) {
                $pco->cronBaixaPatrimonial->parcelas()->create([
                    'numParcela' => $dparcela->numParcela,
                    'dtPrevista' => $dparcela->dtPrevista,
                    'vlr' => $dparcela->vlr,
                ]);
            }
        }

        return $sfpadrao;
    }

    public function inserirSfparcelaOutrosLanc($dcronBaixaPatrimonial,$sfpadrao)
    {
        foreach ($dcronBaixaPatrimonial->parcela as $dparcela) {
            foreach ($sfpadrao->outrosLanc as $outrosLanc) {
                $outrosLanc->cronBaixaPatrimonial->parcelas()->create([
                    'numParcela' => $dparcela->numParcela,
                    'dtPrevista' => $dparcela->dtPrevista,
                    'vlr' => $dparcela->vlr,
                ]);
            }
        }

        return $sfpadrao;
    }
}
