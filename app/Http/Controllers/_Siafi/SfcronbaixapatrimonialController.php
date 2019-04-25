<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfcronbaixapatrimonialController extends Controller
{
    public function inserirSfcronBaixaPatrimonialPco($dpco, $sfpadrao)
    {

        foreach ($dpco->cronBaixaPatrimonial as $dcronBaixaPatrimonial) {
            foreach ($sfpadrao->pco as $pco) {
                $pco->cronBaixaPatrimonial()->create([]);
                if (isset($dcronBaixaPatrimonial->parcela)) {
                    $sfparcela = new SfparcelaController;
                    $sfpadrao = $sfparcela->inserirSfparcelaPco($dcronBaixaPatrimonial,$sfpadrao);
                }
            }
        }

        return $sfpadrao;
    }

    public function inserirSfcronBaixaPatrimonialOutrosLanc($outrosLanc, $sfpadrao)
    {

        foreach ($outrosLanc->cronBaixaPatrimonial as $dcronBaixaPatrimonial) {
            foreach ($sfpadrao->outrosLanc as $outrosLanc) {
                $outrosLanc->cronBaixaPatrimonial()->create([]);
                if (isset($dcronBaixaPatrimonial->parcela)) {
                    $sfparcela = new SfparcelaController;
                    $sfpadrao = $sfparcela->inserirSfparcelaOutrosLanc($dcronBaixaPatrimonial,$sfpadrao);
                }
            }
        }

        return $sfpadrao;
    }
}
