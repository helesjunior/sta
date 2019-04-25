<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfdocrelacionadoController extends Controller
{
    public function inserirSfdocRelacionado($dado,$sfpadrao)
    {
        foreach ($dado->dadosBasicos->docRelacionado as $ddocrelacionado) {
            $sfpadrao->dadosBasicos->docRelacionado()->create([
                'codUgEmit' => $ddocrelacionado->codUgEmit,
                'numDocRelacionado' => $ddocrelacionado->numDocRelacionado,
            ]);
        }

        return $sfpadrao;
    }
}
