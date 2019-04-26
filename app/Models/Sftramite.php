<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sftramite extends Model
{
    protected $table = 'sftramite';

    protected $fillable = [
        'sfdadosbasicos_id',
        'txtLocal',
        'dtEntrada',
        'DtSaida',
    ];

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();

        return $this;
    }
}
