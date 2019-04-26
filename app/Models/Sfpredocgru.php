<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocgru extends Model
{
    protected $table = 'sfpredocgru';

    protected $fillable = [
        'sfpredoc_id',
        'codRecurso',
        'numCodBarras',
        'codUgFavorecida',
        'codRecolhedor',
        'numReferencia',
        'mesCompet',
        'anoCompet',
        'txtProcesso',
        'vlrDocumento',
        'vlrDesconto',
        'vlrOutrDeduc',
        'codRecolhimento',
    ];

    public function createFromXML(array $predocgru)
    {
        $this->fill($predocgru);
        $this->save();

        return $this;
    }

}
