<?php

namespace App\Http\Controllers\Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpredocController extends Controller
{
    public function inserirSfpreDocDeducao($deducao,$sfpadrao)
    {
        foreach ($deducao->predoc as $predoc)
        {
            foreach ($sfpadrao->deducao as $deducao)
            {
                $deducao->predoc()->create([
                    'txtObser' => $predoc->txtObser,
                ]);

                if (isset($predoc->predocOB))
                {
                    $sfpredocob = new SfpredocobController;
                    $sfpadrao = $sfpredocob->inserirSfpreDocObDeducao($predoc,$sfpadrao);
                }

                if (isset($predoc->predocNS))
                {
                    $sfpredocns = new SfpredocnsController;
                    $sfpadrao = $sfpredocns->inserirSfpreDocNsDeducao($predoc,$sfpadrao);
                }

                if (isset($predoc->predocDARF))
                {
                    $sfpredocdarf = new SfpredocdarfController;
                    $sfpadrao = $sfpredocdarf->inserirSfpreDocDarfDeducao($predoc,$sfpadrao);
                }

            }

        }
        return $sfpadrao;
    }
}
