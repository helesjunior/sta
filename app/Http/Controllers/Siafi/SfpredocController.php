<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpredocController extends Controller
{
    public function inserirSfpreDocDeducao($ded, $sfpadrao)
    {
        foreach ($sfpadrao->deducao as $deducao) {
            if($deducao->numSeqItem == $ded->numSeqItem)
            {
                foreach ($ded->predoc as $predoc) {

                    $deducao->predoc()->create([
                        'txtObser' => $predoc->txtObser,
                    ]);

                    if (isset($predoc->predocOB)) {
                        $sfpredocob = new SfpredocobController;
                        $deducao = $sfpredocob->inserirSfpreDocObDeducao($predoc, $deducao);
                    }

                    if (isset($predoc->predocNS)) {
                        $sfpredocns = new SfpredocnsController;
                        $deducao = $sfpredocns->inserirSfpreDocNsDeducao($predoc, $deducao);
                    }

                    if (isset($predoc->predocDARF)) {
                        $sfpredocdarf = new SfpredocdarfController;
                        $deducao = $sfpredocdarf->inserirSfpreDocDarfDeducao($predoc, $deducao);
                    }

                }
            }

        }
        return $sfpadrao;
    }
}
