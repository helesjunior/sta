<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfdocorigemController extends Controller
{
    public function inserirSfdocOrigem($dado, $sfpadrao)
    {
        foreach ($dado->dadosBasicos->docOrigem as $ddocorigem) {
            $sfpadrao->dadosBasicos->docOrigem()->create([
                'codIdentEmit' => $ddocorigem->codIdentEmit,
                'dtEmis' => $ddocorigem->dtEmis ?? null,
                'numDocOrigem' => $ddocorigem->numDocOrigem,
                'vlr' => $ddocorigem->vlr,
            ]);
        }

        return $sfpadrao;
    }
}
