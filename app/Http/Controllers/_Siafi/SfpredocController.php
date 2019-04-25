<?php

namespace App\Http\Controllers\_Siafi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpredocController extends Controller
{
    public function inserirSfpreDocDeducao($preDoc, $model)
    {
        foreach ($model as $deducao) {

            $deducao->predoc()->create([
                'txtObser' => $preDoc->txtObser,
            ]);


            if($deducao->codSit == 'DOB035'){
                echo 'OK<br>';
            }

            if (isset($predoc->predocOB)) {
                echo "entrei<br>";
                $sfpredocob = new SfpredocobController;
                $modelpredocOB = $sfpredocob->inserirSfpreDocObDeducao($predoc, $deducao->predoc);

            }


//            if (isset($preDoc->predocNS)) {
//                $sfpredocns = new SfpredocnsController;
//                $predocNS = $sfpredocns->inserirSfpreDocNsDeducao($preDoc, $deducao);
//            }
//
//            if (isset($preDoc->predocDARF)) {
//                $sfpredocdarf = new SfpredocdarfController;
//                $predocDARF = $sfpredocdarf->inserirSfpreDocDarfDeducao($preDoc, $deducao);
//            }

        }


        return $model;
    }
}
