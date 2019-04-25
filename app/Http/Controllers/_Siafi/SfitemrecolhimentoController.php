<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfitemrecolhimentoController extends Controller
{
    public function inserirSfitemRecolhimentoDeducao($itemRecolhimento, $model)
    {
        foreach ($model as $deducao)
        {
            $deducao->itemRecolhimento()->create([
                'numSeqItem' => $itemRecolhimento->numSeqItem,
                'codRecolhedor' => $itemRecolhimento->codRecolhedor,
                'vlr' => $itemRecolhimento->vlr,
                'vlrBaseCalculo' => $itemRecolhimento->vlrBaseCalculo,
                'vlrMulta' => $itemRecolhimento->vlrMulta,
                'vlrJuros' => $itemRecolhimento->vlrJuros,
                'vlrOutrasEnt' => $itemRecolhimento->vlrOutrasEnt,
                'vlrAtmMultaJuros' => $itemRecolhimento->vlrAtmMultaJuros,
            ]);
        }


        return $model;
    }
}
