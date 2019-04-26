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
        $relCredito = $dado['relCredito'];

        $relCredito['morphcred'] = $this;
        $sfrelCredito = new Sfrelsemitem;
        $sfrelCredito->createFromXml($relCredito);

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
