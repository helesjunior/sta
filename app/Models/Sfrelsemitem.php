<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelsemitem extends Model
{
    protected $table = 'sfrelsemitem';

    protected $fillable = [
        'numSeqItem',
    ];


    public function createFromXML(array $relsemitem)
    {
        $this->fill($relsemitem);

        if(isset($relsemitem['morphcred'])){
            $this->sfrelsemitemcreditoable()->associate($relsemitem['morphcred']);
        }
        if(isset($relsemitem['morphenca'])){
            $this->sfrelsemitemencargoable()->associate($relsemitem['morphenca']);
        }
        if(isset($relsemitem['morphdedu'])){
            $this->sfrelsemitemdeducaoable()->associate($relsemitem['morphdedu']);
        }
        $this->save();


        return $this;
    }



    public function sfrelsemitemcreditoable(){
        return $this->morphTo();
    }
    public function sfrelsemitemencargoable(){
        return $this->morphTo();
    }
    public function sfrelsemitemdeducaoable(){
        return $this->morphTo();
    }
}
