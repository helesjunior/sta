<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocdar extends Model
{
    protected $table = 'sfpredocdar';

    protected $fillable = [
        'sfpredoc_id',
        'codRecurso',
        'mesReferencia',
        'anoReferencia',
        'codUgTmdrServ',
        'numNf',
        'txtSerieNf',
        'numSubSerieNf',
        'codMuniNf',
        'dtEmisNf',
        'vlrNf',
        'numAliqNf',
    ];


    public function createFromXML(array $predocdar)
    {
        $this->fill($predocdar);
        $this->save();

        return $this;
    }


}
