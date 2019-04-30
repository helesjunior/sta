<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfcronbaixapatrimonial extends Model
{
    protected $table = 'sfcronbaixapatrimonial';


    public function createFromXML(array $dado)
    {
        $this->sfcronbaixapatrimonialable()->associate($dado['morph']);
        $this->save();

        $this->createParcelaFromXml($dado);

        return $this;
    }

    private function createParcelaFromXml(array $dado)
    {
        if (!isset($dado['parcela'])) {
            return;
        }

        $parcelas = isset($dado['parcela'][0]) ? $dado['parcela'] : [$dado['parcela']];

        foreach ($parcelas as $parcela) {
            $parcela['sfcronbaixapatrimonial_id'] = $this->id;
            $sfparcela = new Sfparcela;
            $sfparcela->createFromXml($parcela);
        }

    }

    public function deleteParcela($dado){
        foreach ($dado->parcela as $parcela){
            $parcela->delete();
        }
    }


    public function sfcronbaixapatrimonialable()
    {
        return $this->morphTo();
    }

    public function parcelas()
    {
        return $this->hasMany(Sfparcela::class);
    }
}
