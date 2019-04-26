<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdespesaanular extends Model
{
    protected $table = 'sfdespesaanular';

    protected $fillable = [
        'sfpadrao_id',
        'numSeqItem',
        'codSit',
        'codUgEmpe',
        'txtInscrD',
        'numClassD',
        'txtInscrE',
        'numClassE',
    ];

    public function createFromXml(array $dado)
    {

        $this->fill($dado);
        $this->save();

        $this->createDespesaAnularItemFromXml($dado);

        return $this;
    }

    private function createDespesaAnularItemFromXml(array $dado)
    {
        if (!isset($dado['despesaAnularItem'])) {
            return;
        }

        $despesaAnularItems = isset($dado['despesaAnularItem'][0]) ? $dado['despesaAnularItem'] : [$dado['despesaAnularItem']];

        foreach ($despesaAnularItems as $despesaAnularItem) {
            $despesaAnularItem['sfdespesaanular_id'] = $this->id;
            $sfdespesaAnularItem = new Sfdespesaanularitem;
            $sfdespesaAnularItem->createFromXml($despesaAnularItem);
        }

    }

    public function despesaAnularItem()
    {
        return $this->hasMany(Sfdespesaanularitem::class);
    }

}
