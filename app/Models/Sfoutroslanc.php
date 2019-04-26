<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfoutroslanc extends Model
{
    protected $table = 'sfoutroslanc';

    protected $fillable = [
        'sfpadrao_id',
        'numSeqItem',
        'codSit',
        'indrLiquidado',
        'vlr',
        'indrTemContrato',
        'txtInscrA',
        'numClassA',
        'txtInscrB',
        'numClassB',
        'txtInscrC',
        'numClassC',
        'txtInscrD',
        'numClassD',
        'tpNormalEstorno',
    ];


    public function createFromXml(array $dado)
    {

        $this->fill($dado);
        $this->save();

        $this->createCronBaixaPatrimonialFromXml($dado);

        return $this;
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

    public function cronBaixaPatrimonial()
    {
        return $this->morphOne(Sfcronbaixapatrimonial::class, 'sfcronbaixapatrimonialable');
    }

}
