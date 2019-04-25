<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Sfitemrecolhimento extends Model
{
    protected $table = 'sfitemrecolhimento';


    protected $fillable = [
        'numSeqItem',
        'codRecolhedor',
        'vlr',
        'vlrBaseCalculo',
        'vlrMulta',
        'vlrJuros',
        'vlrOutrasEnt',
        'vlrAtmMultaJuros',
    ];

    public function createFromXML(array $itemRecolhimento)
    {

        $this->fill($itemRecolhimento);
        $this->sfitemrecolhimentoable()->associate($itemRecolhimento['morph']);
        $this->save();

        return $this;
    }


    public function sfitemrecolhimentoable()
    {
        return $this->morphTo();
    }
}
