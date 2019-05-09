<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function trataString(string $dado)
    {
        $str = preg_replace('/( )+/', ' ', preg_replace("/[\t\n\r\f\v]/", "", $dado));

        return $str;
    }

    public function formataCnpjCpfTipo($dado, $tipo)
    {
        $retorno = $dado;

        if ($tipo == '1') {
            $d[0] = substr($dado, 0, 2);
            $d[1] = substr($dado, 2, 3);
            $d[2] = substr($dado, 5, 3);
            $d[3] = substr($dado, 8, 4);
            $d[4] = substr($dado, 12, 2);

            $retorno = $d[0] . '.' . $d[1] . '.' . $d[2] . '/' . $d[3] . '-' . $d[4];

        }

        if ($tipo == '2') {
            $d[0] = substr($dado, 0, 3);
            $d[1] = substr($dado, 3, 3);
            $d[2] = substr($dado, 6, 3);
            $d[3] = substr($dado, 9, 2);

            $retorno = $d[0] . '.' . $d[1] . '.' . $d[2] . '-' . $d[3];
        }

        return $retorno;
    }

}
