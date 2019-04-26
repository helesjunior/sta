<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelsemitemvalor extends Model
{
    protected $table = 'sfrelsemitemvalor';

    protected $fillable = [
        'numSeqItem',
        'codNatDespDet',
        'vlr',
    ];

    public function createFromXML(array $domicilio)
    {
        $this->fill($domicilio);

        if (isset($domicilio['morphoutr'])) {
            $this->sfrelsemitemvaloroutroslancable()->associate($domicilio['morphoutr']);
        }
        if (isset($domicilio['morphotlp'])) {
            $this->sfrelsemitemvaloroutroslancpatrimonialable()->associate($domicilio['morphotlp']);
        }
        if (isset($domicilio['morphenca'])) {
            $this->sfrelsemitemvalorencargoable()->associate($domicilio['morphenca']);
        }

        $this->save();

        return $this;
    }

    public function sfrelsemitemvaloroutroslancable()
    {
        return $this->morphTo();
    }

    public function sfrelsemitemvaloroutroslancpatrimonialable()
    {
        return $this->morphTo();
    }

    public function sfrelsemitemvalorencargoable()
    {
        return $this->morphTo();
    }
}
