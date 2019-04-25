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

//        if (isset($deducao->predoc)) {
//            foreach ($deducao->predoc as $predoc) {
//                $sfpredoc = new SfpredocController;
//                $modelPreDoc = $sfpredoc->inserirSfpreDocDeducao($predoc, $modelDeducao);
//            }
//        }

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
        return $this->morphMany(Sfrelcomitem::class, 'sfrelcomitemable');
    }

    public function relPsoItem()
    {
        return $this->morphMany(Sfrelcomitem::class, 'sfrelcomitemable');
    }

    public function relCredito()
    {
        return $this->morphMany(Sfrelsemitem::class, 'sfrelsemitemable');
    }
}
