<?php

namespace App\Http\Controllers\_Siafi;

use App\Models\Sfpadrao;
use SimpleXMLElement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpadraoController extends Controller
{
    public function buscaSfpadrao($dado)
    {
        $sfpadrao = Sfpadrao::where('codUgEmit', $dado->codUgEmit)
            ->where('anoDH', $dado->anoDH)
            ->where('codTipoDH', $dado->codTipoDH)
            ->where('numDH', $dado->numDH)
            ->first();;

        return $sfpadrao;

    }

    /**
     * @param $dado
     * @return Sfpadrao
     */
    public function inserirSfpadrao(SimpleXMLElement $dado)
    {

        $sfpadrao = new Sfpadrao;
        $sfpadrao->codUgEmit = $dado->codUgEmit;
        $sfpadrao->anoDH = $dado->anoDH;
        $sfpadrao->codTipoDH = $dado->codTipoDH;
        $sfpadrao->numDH = $dado->numDH;
        $sfpadrao->save();


        if (isset($dado->dadosBasicos)) {
            $sfdadosbasicos = new SfdadosbasicosController;
            $sfpadrao = $sfdadosbasicos->inserirSfdadosBasicos($dado,$sfpadrao);
        }

        if (isset($dado->pco)) {
            $sfpco = new SfpcoController;
            $sfpadrao = $sfpco->inserirSfpco($dado,$sfpadrao);
        }

        if (isset($dado->pso)) {
            $sfpso = new SfpsoController;
            $sfpadrao = $sfpso->inserirSfpso($dado,$sfpadrao);
        }

        if (isset($dado->credito)) {
            $sfcredito = new SfcreditoController;
            $sfpadrao = $sfcredito->inserirSfcredito($dado,$sfpadrao);
        }

        if (isset($dado->outrosLanc)) {
            $sfoutroslanc = new SfoutroslancController;
            $sfpadrao = $sfoutroslanc->inserirSfoutrosLanc($dado,$sfpadrao);
        }

        if (isset($dado->deducao)) {
            foreach($dado->deducao as $deducao)
            {
                $sfdeducao = new SfdeducaoController;
                $deducao = $sfdeducao->inserirSfdeducao($deducao,$sfpadrao);
            }

        }




        return $sfpadrao;

    }

    public function atualizaSfpadrao($dado)
    {
        $sfpadrao = new Sfpadrao;

        $sfpadrao->codUgEmit = $dado->codUgEmit;
        $sfpadrao->anoDH = $dado->anoDH;
        $sfpadrao->codTipoDH = $dado->codTipoDH;
        $sfpadrao->numDH = $dado->numDH;
        $sfpadrao->save();

        return $sfpadrao;

    }
}
