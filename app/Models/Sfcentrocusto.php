<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfcentrocusto extends Model
{
    protected $table = 'sfcentrocusto';

    protected $fillable = [
        'sfpadrao_id',
        'numSeqItem',
        'codCentroCusto',
        'mesReferencia',
        'anoReferencia',
        'codUgBenef',
        'codSIORG',
    ];

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();

        //relcomitemvalor
        $this->createrelPcoItemFromXml($dado);
        $this->createrelPsoItemFromXml($dado);
        $this->createrelAcrescimoDeducaoFromXml($dado);
        $this->createrelAcrescimoEncargoFromXml($dado);
        $this->createrelAcrescimoDadosPagFromXml($dado);
        $this->createrelDespesaAntecipadaFromXml($dado);
        $this->createrelDespesaAnularFromXml($dado);

        //relsemitemvalor
        $this->createrelOutrosLancFromXml($dado);
        $this->createrelOutrosLancCronogramaPatrimonialFromXml($dado);
        $this->createrelEncargoFromXml($dado);

        return $this;
    }

    private function createrelOutrosLancFromXml(array $dado)
    {
        if (!isset($dado['relOutrosLanc'])) {
            return;
        }
        $relOutrosLancs = isset($dado['relOutrosLanc'][0]) ? $dado['relOutrosLanc'] : [$dado['relOutrosLanc']];

        foreach ($relOutrosLancs as $relOutrosLanc) {
            $relOutrosLanc['morphoutr'] = $this;
            $sfrelOutrosLanc = new Sfrelsemitemvalor;
            $sfrelOutrosLanc->createFromXml($relOutrosLanc);
        }

    }

    private function createrelOutrosLancCronogramaPatrimonialFromXml(array $dado)
    {
        if (!isset($dado['relOutrosLancCronogramaPatrimonial'])) {
            return;
        }
        $relOutrosLancCronogramaPatrimonials = isset($dado['relOutrosLancCronogramaPatrimonial'][0]) ? $dado['relOutrosLancCronogramaPatrimonial'] : [$dado['relOutrosLancCronogramaPatrimonial']];

        foreach ($relOutrosLancCronogramaPatrimonials as $relOutrosLancCronogramaPatrimonial) {
            $relOutrosLancCronogramaPatrimonial['morphotlp'] = $this;
            $sfrelOutrosLancCronogramaPatrimonial = new Sfrelsemitemvalor;
            $sfrelOutrosLancCronogramaPatrimonial->createFromXml($relOutrosLancCronogramaPatrimonial);
        }

    }

    private function createrelEncargoFromXml(array $dado)
    {
        if (!isset($dado['relEncargo'])) {
            return;
        }
        $relEncargos = isset($dado['relEncargo'][0]) ? $dado['relEncargo'] : [$dado['relEncargo']];

        foreach ($relEncargos as $relEncargo) {
            $relEncargo['morphenca'] = $this;
            $sfrelEncargo = new Sfrelsemitemvalor;
            $sfrelEncargo->createFromXml($relEncargo);
        }

    }

    private function createrelPcoItemFromXml(array $dado)
    {
        if (!isset($dado['relPcoItem'])) {
            return;
        }
        $relPcoItems = isset($dado['relPcoItem'][0]) ? $dado['relPcoItem'] : [$dado['relPcoItem']];

        foreach ($relPcoItems as $relPcoItem) {
            $relPcoItem['morphpco'] = $this;
            $sfrelPcoItem = new Sfrelcomitemvalor;
            $sfrelPcoItem->createFromXml($relPcoItem);
        }

    }

    private function createrelPsoItemFromXml(array $dado)
    {
        if (!isset($dado['relPsoItem'])) {
            return;
        }
        $relPsoItems = isset($dado['relPsoItem'][0]) ? $dado['relPsoItem'] : [$dado['relPsoItem']];

        foreach ($relPsoItems as $relPsoItem) {
            $relPsoItem['morphpso'] = $this;
            $sfrelPsoItem = new Sfrelcomitemvalor;
            $sfrelPsoItem->createFromXml($relPsoItem);
        }

    }

    private function createrelAcrescimoDeducaoFromXml(array $dado)
    {
        if (!isset($dado['relAcrescimoDeducao'])) {
            return;
        }
        $relAcrescimoDeducaos = isset($dado['relAcrescimoDeducao'][0]) ? $dado['relAcrescimoDeducao'] : [$dado['relAcrescimoDeducao']];

        foreach ($relAcrescimoDeducaos as $relAcrescimoDeducao) {
            $relAcrescimoDeducao['morphaded'] = $this;
            $sfrelAcrescimoDeducao = new Sfrelcomitemvalor;
            $sfrelAcrescimoDeducao->createFromXml($relAcrescimoDeducao);
        }

    }

    private function createrelAcrescimoEncargoFromXml(array $dado)
    {
        if (!isset($dado['relAcrescimoEncargo'])) {
            return;
        }
        $relAcrescimoEncargos = isset($dado['relAcrescimoEncargo'][0]) ? $dado['relAcrescimoEncargo'] : [$dado['relAcrescimoEncargo']];

        foreach ($relAcrescimoEncargos as $relAcrescimoEncargo) {
            $relAcrescimoEncargo['morphaenc'] = $this;
            $sfrelAcrescimoEncargo = new Sfrelcomitemvalor;
            $sfrelAcrescimoEncargo->createFromXml($relAcrescimoEncargo);
        }

    }

    private function createrelAcrescimoDadosPagFromXml(array $dado)
    {
        if (!isset($dado['relAcrescimoDadosPag'])) {
            return;
        }
        $relAcrescimoDadosPags = isset($dado['relAcrescimoDadosPag'][0]) ? $dado['relAcrescimoDadosPag'] : [$dado['relAcrescimoDadosPag']];

        foreach ($relAcrescimoDadosPags as $relAcrescimoDadosPag) {
            $relAcrescimoDadosPag['morphapgt'] = $this;
            $sfrelAcrescimoDadosPag = new Sfrelcomitemvalor;
            $sfrelAcrescimoDadosPag->createFromXml($relAcrescimoDadosPag);
        }

    }

    private function createrelDespesaAntecipadaFromXml(array $dado)
    {
        if (!isset($dado['relDespesaAntecipada'])) {
            return;
        }
        $relDespesaAntecipadas = isset($dado['relDespesaAntecipada'][0]) ? $dado['relDespesaAntecipada'] : [$dado['relDespesaAntecipada']];

        foreach ($relDespesaAntecipadas as $relDespesaAntecipada) {
            $relDespesaAntecipada['morphadan'] = $this;
            $sfrelDespesaAntecipada = new Sfrelcomitemvalor;
            $sfrelDespesaAntecipada->createFromXml($relDespesaAntecipada);
        }

    }

    private function createrelDespesaAnularFromXml(array $dado)
    {
        if (!isset($dado['relDespesaAnular'])) {
            return;
        }
        $relDespesaAnulars = isset($dado['relDespesaAnular'][0]) ? $dado['relDespesaAnular'] : [$dado['relDespesaAnular']];

        foreach ($relDespesaAnulars as $relDespesaAnular) {
            $relDespesaAnular['morphadsa'] = $this;
            $sfrelDespesaAnular = new Sfrelcomitemvalor;
            $sfrelDespesaAnular->createFromXml($relDespesaAnular);
        }

    }


    public function deleterelPcoItem($dado)
    {
        foreach ($dado->relPcoItem as $relPcoItem) {
            $relPcoItem->delete();
        }
    }

    public function deleterelOutrosLanc($dado)
    {
        foreach ($dado->relOutrosLanc as $relOutrosLanc) {
            $relOutrosLanc->delete();
        }
    }

    public function deleterelOutrosLancCronogramaPatrimonial($dado)
    {
        foreach ($dado->relOutrosLancCronogramaPatrimonial as $relOutrosLancCronogramaPatrimonial) {
            $relOutrosLancCronogramaPatrimonial->delete();
        }
    }

    public function deleterelPsoItem($dado)
    {
        foreach ($dado->relPsoItem as $relPsoItem) {
            $relPsoItem->delete();
        }
    }

    public function deleterelEncargo($dado)
    {
        foreach ($dado->relEncargo as $relEncargo) {
            $relEncargo->delete();
        }
    }

    public function deleterelAcrescimoDeducao($dado)
    {
        foreach ($dado->relAcrescimoDeducao as $relAcrescimoDeducao) {
            $relAcrescimoDeducao->delete();
        }
    }

    public function deleterelAcrescimoEncargo($dado)
    {
        foreach ($dado->relAcrescimoEncargo as $relAcrescimoEncargo) {
            $relAcrescimoEncargo->delete();
        }
    }

    public function deleterelAcrescimoDadosPag($dado)
    {
        foreach ($dado->relAcrescimoDadosPag as $relAcrescimoDadosPag) {
            $relAcrescimoDadosPag->delete();
        }
    }

    public function deleterelDespesaAntecipada($dado)
    {
        foreach ($dado->relDespesaAntecipada as $relDespesaAntecipada) {
            $relDespesaAntecipada->delete();
        }
    }

    public function deleterelDespesaAnular($dado)
    {
        foreach ($dado->relDespesaAnular as $relDespesaAnular) {
            $relDespesaAnular->delete();
        }
    }


    public function retornaCentroCustoMesAnoUg(string $mes, string $ano, string $ug)
    {
        $busca = $this->whereHas('sfpadrao', function ($q) use ($ug){
            $q->where('codUgEmit',$ug);
        });
        $busca->where('mesReferencia', $mes);
        $busca->where('anoReferencia', $ano);

        return $busca->get();
    }



    public function relPcoItem()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalorpcoable');
    }

    public function relOutrosLanc()
    {
        return $this->morphMany(Sfrelsemitemvalor::class, 'sfrelsemitemvaloroutroslancable');
    }

    public function relOutrosLancCronogramaPatrimonial()
    {
        return $this->morphMany(Sfrelsemitemvalor::class, 'sfrelsemitemvaloroutroslancpatrimonialable');
    }

    public function relPsoItem()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalorpsoable');
    }

    public function relEncargo()
    {
        return $this->morphMany(Sfrelsemitemvalor::class, 'sfrelsemitemvalorencargoable');
    }

    public function relAcrescimoDeducao()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvaloracresdeducaoable');
    }

    public function relAcrescimoEncargo()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvaloracresencargoable');
    }

    public function relAcrescimoDadosPag()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvaloracresdadospgtoable');
    }

    public function relDespesaAntecipada()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalordespantecipadaable');
    }

    public function relDespesaAnular()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalordespesaanularable');
    }

    public function sfpadrao()
    {
        return $this->belongsTo(Sfpadrao::class, 'sfpadrao_id');
    }

}
