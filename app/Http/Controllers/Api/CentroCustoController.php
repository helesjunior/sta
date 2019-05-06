<?php

namespace App\Http\Controllers\Api;

use App\Models\Sfcentrocusto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CentroCustoController extends Controller
{
    public function buscaCentroCustoPorMesrefUg(string $mesref, string $ug)
    {
        $tammesref = strlen($mesref);

        if ($tammesref != 6) {
            return "Mês Referencia formato diferente de MMAAAA. Exemplo: 082015";
        }

        $mes = substr($mesref, 0, 2);
        if (substr($mes, 0, 1) == '0') {
            $mes = substr($mes, 1, 1);
        }
        $ano = substr($mesref, 2, 4);


        $retorno = [];


        $centrocusto = new Sfcentrocusto;

        $retorno = $centrocusto->retornaCentroCustoMesAnoUg($mes,$ano,$ug);


        return json_encode($retorno);

    }



}
