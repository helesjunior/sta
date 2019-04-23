<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfitemrecolhimentoController extends Controller
{
    public function inserirSfitemRecolhimentoDeducao($deducao,$sfpadrao)
    {
        foreach ($deducao->itemRecolhimento as $itemRecolhimento)
        {
            foreach ($sfpadrao->deducao as $deducao)
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
        }

        return $sfpadrao;
    }
}
