<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdespesaanularitem extends Model
{
    protected $table = 'sfdespesaanularitem';

    protected $fillable = [
        'sfdespesaanular_id',
        'numSeqItem',
        'numEmpe',
        'codSubItemEmpe',
        'vlr',
        'txtInscrA',
        'numClassA',
        'txtInscrB',
        'numClassB',
        'txtInscrC',
        'numClassC',
    ];

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();

        $this->createRelEncargoFromXml($dado);

        return $this;
    }

    private function createRelEncargoFromXml(array $dado)
    {
        if (!isset($dado['relEncargo'])) {
            return;
        }
        $relEncargos = isset($dado['relEncargo'][0]) ? $dado['relEncargo'] : [$dado['relEncargo']];

        foreach ($relEncargos as $relEncargo) {
            $relEncargo['morphenca'] = $this;
            $sfrelEncargo = new Sfrelsemitem;
            $sfrelEncargo->createFromXml($relEncargo);
        }

    }

    public function deleterelEncargo($dado){
        foreach ($dado->relEncargo as $relEncargo){
            $relEncargo->delete();
        }
    }

    public function relEncargo()
    {
        return $this->morphMany(Sfrelsemitem::class, 'sfrelsemitemdeducaoable');
    }
}
