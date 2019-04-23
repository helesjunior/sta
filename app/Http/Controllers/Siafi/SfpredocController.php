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
                    $sfpadrao = $sfpredocob->inserirSfpreDocOb($predoc,$sfpadrao);
                }

            }

        }
        return $sfpadrao;
    }
}
