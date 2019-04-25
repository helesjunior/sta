<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpredocdarfController extends Controller
{
    public function inserirSfpreDocDarfDeducao($predoc, $sfpadrao)
    {
        foreach ($predoc->predocDARF as $predocDarf) {
            $sfpadrao->predoc->predocDARF()->create([
                'codTipoDARF' => $predocDarf->codTipoDARF,
                'codRecurso' => $predocDarf->codRecurso,
                'dtPrdoApuracao' => $predocDarf->dtPrdoApuracao ?? null,
                'numRef' => $predocDarf->numRef,
                'txtProcesso' => $predocDarf->txtProcesso,
                'vlrRctaBrutaAcum' => $predocDarf->vlrRctaBrutaAcum ?? null,
                'vlrPercentual' => $predocDarf->vlrPercentual ?? null,
                'numCodBarras' => $predocDarf->numCodBarras,
                'vinculacaoPgto' => $predocDarf->vinculacaoPgto ?? null,
            ]);
        }

        return $sfpadrao;
    }
}
