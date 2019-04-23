<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SftramiteController extends Controller
{
    public function inserirSftramite($dado,$sfpadrao)
    {
        foreach ($dado->dadosBasicos->tramite as $dtramite) {
            $sfpadrao->dadosBasicos->tramite()->create([
                'txtLocal' => $dtramite->txtLocal,
                'dtEntrada' => $dtramite->dtEntrada,
                'DtSaida' => $dtramite->DtSaida,
            ]);
        }

        return $sfpadrao;
    }
}
