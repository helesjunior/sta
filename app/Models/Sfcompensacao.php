<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfcompensacao extends Model
{
    protected $table = 'sfcompensacao';

    protected $fillable = [
        'sfpadrao_id',
        'numSeqItem',
        'codSit',
        'vlr',
        'txtInscrA',
        'numClassA',
    ];

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();

        $this->createRelEncargoItemFromXml($dado);
        $this->createrelDeducaoItemFromXml($dado);

        return $this;
    }

    private function createRelEncargoItemFromXml(array $dado)
    {
        if (!isset($dado['relEncargoItem'])) {
            return;
        }
        $relEncargos = isset($dado['relEncargoItem'][0]) ? $dado['relEncargoItem'] : [$dado['relEncargoItem']];

        foreach ($relEncargos as $relEncargo) {
            $relEncargo['morphenca'] = $this;
            $sfrelEncargo = new Sfrelsemitem;
            $sfrelEncargo->createFromXml($relEncargo);
        }

    }

    private function createrelDeducaoItemFromXml(array $dado)
    {
        if (!isset($dado['relDeducaoItem'])) {
            return;
        }
        $relDeducaoItems = isset($dado['relDeducaoItem'][0]) ? $dado['relDeducaoItem'] : [$dado['relDeducaoItem']];

        foreach ($relDeducaoItems as $relDeducaoItem) {
            $relDeducaoItem['morphdedu'] = $this;
            $sfrelDeducaoItem = new Sfrelsemitem;
            $sfrelDeducaoItem->createFromXml($relDeducaoItem);
        }

    }

    public function relDeducaoItem()
    {
        return $this->morphMany(Sfrelsemitem::class, 'sfrelsemitemable');
    }

    public function relEncargoItem()
    {
        return $this->morphMany(Sfrelsemitem::class, 'sfrelsemitemable');
    }
}
