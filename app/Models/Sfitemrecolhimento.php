<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function sfitemrecolhimentoable(){
        return $this->morphTo();
    }
}
