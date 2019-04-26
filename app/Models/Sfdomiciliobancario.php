<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdomiciliobancario extends Model
{
    protected $table = 'sfdomiciliobancario';

    protected $fillable = [
        'banco',
        'agencia',
        'conta'
    ];


    public function createFromXML(array $domicilio)
    {
        $this->fill($domicilio);
        if(isset($domicilio['morphfav'])){
            $this->numdomibancfavoable()->associate($domicilio['morphfav']);
        }

        if(isset($domicilio['morphpgto'])){
            $this->numdomibancpgtoable()->associate($domicilio['morphpgto']);
        }

        $this->save();


        return $this;
    }


    public function numdomibancfavoable()
    {
        return $this->morphTo();
    }

    public function numdomibancpgtoable()
    {
        return $this->morphTo();
    }

}
