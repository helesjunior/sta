<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfdomiciliobancarioController extends Controller
{
    public function inserirSfnumDomiBancFavoPreDocOb($predocob,$sfpadrao)
    {
        foreach ($sfpadrao->deducao as $deducao) {
            $deducao->predoc->predocOb->numDomiBancFavo()->create([
                'banco' => $predocob->numDomiBancFavo->banco ?? null,
                'agencia' => $predocob->numDomiBancFavo->agencia ?? null,
                'conta' => $predocob->numDomiBancFavo->conta,
            ]);
        }

        return $sfpadrao;
    }

    public function inserirSfnumDomiBancPgtoPreDocOb($predocob,$sfpadrao)
    {
        foreach ($sfpadrao->deducao as $deducao) {
            $deducao->predoc->predocOb->numDomiBancPgto()->create([
                'banco' => $predocob->numDomiBancPgto->banco ?? null,
                'agencia' => $predocob->numDomiBancPgto->agencia ?? null,
                'conta' => $predocob->numDomiBancPgto->conta,
            ]);
        }

        return $sfpadrao;
    }

    public function inserirSfnumDomiBancPgtoPreDocNs($predocns,$sfpadrao)
    {
        foreach ($sfpadrao->deducao as $deducao) {
            $deducao->predoc->predocNs->numDomiBancPgto()->create([
                'banco' => $predocns->numDomiBancPgto->banco ?? null,
                'agencia' => $predocns->numDomiBancPgto->agencia ?? null,
                'conta' => $predocns->numDomiBancPgto->conta,
            ]);
        }

        return $sfpadrao;
    }
}
