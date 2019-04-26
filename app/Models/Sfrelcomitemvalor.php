<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelcomitemvalor extends Model
{
    protected $table = 'sfrelcomitemvalor';

    protected $fillable = [
        'numSeqPai',
        'numSeqItem',
        'codNatDespDet',
        'vlr',
    ];

    public function createFromXML(array $domicilio)
    {
        $this->fill($domicilio);

        if (isset($domicilio['morphpco'])) {
            $this->sfrelcomitemvalorpcoable()->associate($domicilio['morphpco']);
        }
        if (isset($domicilio['morphpso'])) {
            $this->sfrelcomitemvalorpsoable()->associate($domicilio['morphpso']);
        }
        if (isset($domicilio['morphaded'])) {
            $this->sfrelcomitemvaloracresdeducaoable()->associate($domicilio['morphaded']);
        }
        if (isset($domicilio['morphaenc'])) {
            $this->sfrelcomitemvaloracresencargoable()->associate($domicilio['morphaenc']);
        }
        if (isset($domicilio['morphapgt'])) {
            $this->sfrelcomitemvaloracresdadospgtoable()->associate($domicilio['morphapgt']);
        }
        if (isset($domicilio['morphadan'])) {
            $this->sfrelcomitemvalordespantecipadaable()->associate($domicilio['morphadan']);
        }
        if (isset($domicilio['morphpadsa'])) {
            $this->sfrelcomitemvalordespesaanularable()->associate($domicilio['morphpadsa']);
        }

        $this->save();

        return $this;
    }


    public function sfrelcomitemvalorpcoable()
    {
        return $this->morphTo();
    }

    public function sfrelcomitemvalorpsoable()
    {
        return $this->morphTo();
    }

    public function sfrelcomitemvaloracresdeducaoable()
    {
        return $this->morphTo();
    }

    public function sfrelcomitemvaloracresencargoable()
    {
        return $this->morphTo();
    }

    public function sfrelcomitemvaloracresdadospgtoable()
    {
        return $this->morphTo();
    }

    public function sfrelcomitemvalordespantecipadaable()
    {
        return $this->morphTo();
    }

    public function sfrelcomitemvalordespesaanularable()
    {
        return $this->morphTo();
    }
}
