<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocns extends Model
{
    protected $table = 'sfpredocns';

    protected $fillable = [
        'sfpredoc_id',
        'codCredorDevedor',
        'codTipoBanco',
        'codInscGen',
    ];

    public function createFromXML(array $predocns)
    {
        $this->fill($predocns);
        $this->save();

        $this->createnumDomiBancPgtoFromXml($predocns);

        return $this;
    }

    private function createnumDomiBancPgtoFromXml(array $dado)
    {
        if (!isset($dado['numDomiBancPgto'])) {
            return;
        }
        $domiciliobancario = $dado['numDomiBancPgto'];

        $domiciliobancario['morphpgto'] = $this;
        $sfdomicilio = new Sfdomiciliobancario;
        $sfdomicilio->createFromXml($domiciliobancario);

    }


    public function numdomibancpgto()
    {
        return $this->morphOne(Sfdomiciliobancario::class, 'numgomibancpgtoable');
    }
}
