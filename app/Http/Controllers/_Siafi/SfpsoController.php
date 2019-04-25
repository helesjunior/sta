<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpsoController extends Controller
{
    public function inserirSfpso($dado,$sfpadrao)
    {
        foreach ($dado->pso as $pso) {
            $sfpadrao->pso()->create([
                'numSeqItem' => $pso->numSeqItem,
                'codSit' => $pso->codSit,
                'txtInscrE' => $pso->txtInscrE,
                'numClassE' => $pso->numClassE ?? null,
                'txtInscrF' => $pso->txtInscrF,
                'numClassF' => $pso->numClassF ?? null,
            ]);

            if (isset($pso->psoItem)) {
                $sfpsoitem = new SfpsoitemController;
                $sfpadrao = $sfpsoitem->inserirSfpsoItem($pso,$sfpadrao);
            }

        }

        return $sfpadrao;
    }
}
