<?php

namespace App\Http\Controllers\Siafi;

use App\Models\Sfpadrao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpadraoController extends Controller
{
    public function buscaSfpadrao($dado)
    {
        $sfpadrao = Sfpadrao::where('codUgEmit',$dado->codUgEmit)
        ->where('anoDH',$dado->anoDH)
        ->where('codTipoDH', $dado->codTipoDH)
        ->where('numDH', $dado->numDH)
        ->first();;

       return $sfpadrao;

    }

    public function inserirSfpadrao($dado)
    {
        $sfpadrao = new Sfpadrao;

        $sfpadrao->codUgEmit = $dado->codUgEmit;
        $sfpadrao->anoDH = $dado->anoDH;
        $sfpadrao->codTipoDH = $dado->codTipoDH;
        $sfpadrao->numDH = $dado->numDH;
        $sfpadrao->save();

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
