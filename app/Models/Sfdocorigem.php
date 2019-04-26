<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdocorigem extends Model
{
    protected $table = 'sfdocorigem';

    protected $fillable = [
        'sfdadosbasicos_id',
        'codIdentEmit',
        'dtEmis',
        'numDocOrigem',
        'vlr',
    ];

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();

        return $this;
    }

}
