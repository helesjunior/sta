<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Int_;

class Sfdeducao extends Model
{
    protected $table = 'sfdeducao';


    protected $fillable = [
        'sfpadrao_id',
        'numSeqItem',
        'codSit',
        'dtVenc',
        'dtPgtoReceb',
        'codUgPgto',
        'vlr',
        'txtInscrA',
        'numClassA',
        'txtInscrB',
        'numClassB',
        'txtInscrC',
        'numClassC',
        'txtInscrD',
        'numClassD',
    ];



    public function createFromXml(array $deducao)
    {
        $this->fill($deducao);
        $this->save();

        $this->createItemRecolhimentoFromXml($deducao);
        $this->createPreDocFromXml($deducao);
        $this->createAcrescimoFromXml($deducao);
        $this->createRelPcoItemFromXml($deducao);
        $this->createRelPsoItemFromXml($deducao);
        $this->createRelCreditoFromXml($deducao);

        return $this;
    }


    private function createItemRecolhimentoFromXml(array $dado)
    {
        if (!isset($dado['itemRecolhimento'])) {
            return;
        }

        $itemRecolhimentos = isset($dado['itemRecolhimento'][0]) ? $dado['itemRecolhimento'] : [$dado['itemRecolhimento']];

        foreach ($itemRecolhimentos as $itemRecolhimento) {
            $itemRecolhimento['morph'] = $this;
            $sfitemrecolhimento = new Sfitemrecolhimento;
            $sfitemrecolhimento->createFromXml($itemRecolhimento);
        }

    }

    private function createPreDocFromXml(array $dado)
    {
        if (!isset($dado['predoc'])) {
            return;
        }
        $predoc = $dado['predoc'];

        $predoc['morph'] = $this;
        $sfpredoc = new Sfpredoc;
        $sfpredoc->createFromXml($predoc);

    }

    private function createAcrescimoFromXml(array $dado)
    {
        if (!isset($dado['acrescimo'])) {
            return;
        }
        $acrescimo = $dado['acrescimo'];

        $acrescimo['morph'] = $this;
        $sfacrescimo = new Sfacrescimo;
        $sfacrescimo->createFromXml($acrescimo);

    }

    private function createRelPcoItemFromXml(array $dado)
    {
        if (!isset($dado['relPcoItem'])) {
            return;
        }
        $relPcoItem = $dado['relPcoItem'];

        $relPcoItem['morphpco'] = $this;
        $sfrelPcoItem = new Sfrelcomitem;
        $sfrelPcoItem->createFromXml($relPcoItem);

    }

    private function createRelPsoItemFromXml(array $dado)
    {
        if (!isset($dado['relPsoItem'])) {
            return;
        }
        $relPsoItem = $dado['relPsoItem'];

        $relPsoItem['morphpso'] = $this;
        $sfrelPsoItem = new Sfrelcomitem;
        $sfrelPsoItem->createFromXml($relPsoItem);

    }

    private function createRelCreditoFromXml(array $dado)
    {
        if (!isset($dado['relCredito'])) {
            return;
        }
        $relCreditos = isset($dado['relCredito'][0]) ? $dado['relCredito'] : [$dado['relCredito']];

        foreach ($relCreditos as $relCredito) {
            $relCredito['morphcred'] = $this;
            $sfrelCredito = new Sfrelsemitem;
            $sfrelCredito->createFromXml($relCredito);
        }

    }

    public function deleteAcrescimo($dado){
        foreach ($dado->acrescimo as $acrescimo){
            $acrescimo->delete();
        }
    }

    public function deleterelPcoItem($dado){
        foreach ($dado->relPcoItem as $relPcoItem){
            $relPcoItem->delete();
        }
    }

    public function deleterelPsoItem($dado){
        foreach ($dado->relPsoItem as $relPsoItem){
            $relPsoItem->delete();
        }
    }

    public function deleterelCredito($dado){
        foreach ($dado->relCredito as $relCredito){
            $relCredito->delete();
        }
    }

    public function deleteItemRecolhimento($dado){
        foreach ($dado->itemRecolhimento as $itemrecolhimento){
            $itemrecolhimento->delete();
        }
    }

    public function deletepredoc($dado){

        if(isset($dado->predoc->predocOB)){
            $predocob = new Sfpredocob();
            $predocob->deleteDomicilioBancarioFav($dado->predoc->predocOB);
            $predocob->deleteDomicilioBancarioPgto($dado->predoc->predocOB);
        }

        if(isset($dado->predoc->predocNS)){
            $predocns = new Sfpredocns();
            $predocns->deleteDomicilioBancarioPgto($dado->predoc->predocNS);
        }

        $dado->predoc()->delete();

    }

    public function itemRecolhimento()
    {
        return $this->morphMany(Sfitemrecolhimento::class, 'sfitemrecolhimentoable');
    }

    public function predoc()
    {
        return $this->morphOne(Sfpredoc::class, 'sfpredocable');
    }

    public function acrescimo()
    {
        return $this->morphMany(Sfacrescimo::class, 'sfacrescimoable');
    }

    public function relPcoItem()
    {
        return $this->morphMany(Sfrelcomitem::class, 'sfrelcomitempcoable');
    }

    public function relPsoItem()
    {
        return $this->morphMany(Sfrelcomitem::class, 'sfrelcomitempsoable');
    }

    public function relCredito()
    {
        return $this->morphMany(Sfrelsemitem::class, 'sfrelsemitemcreditoable');
    }
}
