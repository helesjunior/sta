<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpco extends Model
{
    protected $table = 'sfpco';

    protected $fillable = [
        'sfpadrao_id',
        'numSeqItem',
        'codSit',
        'codUgEmpe',
        'indrTemContrato',
        'txtInscrD',
        'numClassD',
        'txtInscrE',
        'numClassE',
    ];

    public function createFromXml(array $dado)
    {

        $this->fill($dado);
        $this->save();

        $this->createPcoItemFromXml($dado);
        $this->createCronBaixaPatrimonialFromXml($dado);

        return $this;
    }

    private function createPcoItemFromXml(array $dado)
    {
        if (!isset($dado['pcoItem'])) {
            return;
        }

        $pcoItens = isset($dado['pcoItem'][0]) ? $dado['pcoItem'] : [$dado['pcoItem']];

        foreach ($pcoItens as $pcoItem) {
            $pcoItem['sfpco_id'] = $this->id;
            $sfpcoitem = new Sfpcoitem;
            $sfpcoitem->createFromXml($pcoItem);
        }

    }

    private function createCronBaixaPatrimonialFromXml(array $dado)
    {
        if (!isset($dado['cronBaixaPatrimonial'])) {
            return;
        }

        $cronBaixaPatrimonial = $dado['cronBaixaPatrimonial'];

        $cronBaixaPatrimonial['morph'] = $this;
        $sfcronBaixaPatrimonial = new Sfcronbaixapatrimonial;
        $sfcronBaixaPatrimonial->createFromXml($cronBaixaPatrimonial);

    }


    public function pcoItens()
    {
        return $this->hasMany(Sfpcoitem::class);
    }

    public function cronBaixaPatrimonial()
    {
        return $this->morphOne(Sfcronbaixapatrimonial::class, 'sfcronbaixapatrimonialable');
    }

}
