<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdadospgto extends Model
{
    protected $table = 'sfdadospgto';

    protected $fillable = [
        'sfpadrao_id',
        'codCredorDevedor',
        'vlr',
    ];

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();

        $this->createItemRecolhimentoFromXml($dado);
        $this->createPreDocFromXml($dado);
        $this->createAcrescimoFromXml($dado);

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


    public function deleteAcrescimo($dado){
        foreach ($dado->acrescimo as $acrescimo){
            $acrescimo->delete();
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
}
