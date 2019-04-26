<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdoccontabilizacao extends Model
{
    protected $table = 'sfdoccontabilizacao';

    protected $fillable = [
        'sfpadrao_id',
        'anoDocCont',
        'codTipoDocCont',
        'numDocCont',
        'codUgEmit',
    ];

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();

        return $this;
    }

}
