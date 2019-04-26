<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocgfip extends Model
{
    protected $table = 'sfpredocgfip';

    protected $fillable = [
        'sfpredoc_id',
        'codRecurso',
        'numCodBarras',
        'codAgencia',
        'numIdentGfip',
        'numIdRecolhimento',
        'codFpas',
        'codEntidades',
        'indrSimples',
        'numQtdTrabalhor',
        'vlrRmesFgts',
        'vlrRmesCat',
        'vlrMensInss',
        'Vlr13SalrInss',
        'vlrContSegDev',
        'vlrPrevSocial',
        'vlrContSegDesc',
        'vlrDepContSocial',
        'vlrEncargos',
    ];


    public function createFromXML(array $predocgfip)
    {
        $this->fill($predocgfip);
        $this->save();

        return $this;
    }
}
