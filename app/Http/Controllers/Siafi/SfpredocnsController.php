<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpredocnsController extends Controller
{
    public function inserirSfpreDocNsDeducao($predoc, $sfpadrao)
    {
        foreach ($predoc->predocNS as $predocNs) {
            $sfpadrao->predoc->predocNS()->create([
                'codCredorDevedor' => $predocNs->codCredorDevedor,
                'codTipoBanco' => $predocNs->codTipoBanco,
                'codInscGen' => $predocNs->codInscGen,
            ]);

            if (isset($predocNs->numDomiBancPgto)) {
                $sfdomiciliobancario = new SfdomiciliobancarioController;
                $sfpadrao = $sfdomiciliobancario->inserirSfnumDomiBancPgtoPreDocNs($predocNs, $sfpadrao);
            }

        }

        return $sfpadrao;
    }
}
