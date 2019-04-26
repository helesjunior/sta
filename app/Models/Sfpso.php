<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpso extends Model
{
    protected $table = 'sfpso';


    protected $fillable = [
        'sfpadrao_id',
        'numSeqItem',
        'codSit',
        'txtInscrE',
        'numClassE',
        'txtInscrF',
        'numClassF',
    ];


    public function createFromXml(array $dado)
    {

        $this->fill($dado);
        $this->save();

        $this->createPsoItemFromXml($dado);

        return $this;
    }

    private function createPsoItemFromXml(array $dado)
    {
        if (!isset($dado['psoItem'])) {
            return;
        }

        $psoItens = isset($dado['psoItem'][0]) ? $dado['psoItem'] : [$dado['psoItem']];

        foreach ($psoItens as $psoItem) {
            $psoItem['sfpso_id'] = $this->id;
            $sfpsoitem = new Sfpsoitem;
            $sfpsoitem->createFromXml($psoItem);
        }

    }

    public function psoItens()
    {
        return $this->hasMany(Sfpsoitem::class);
    }

}
