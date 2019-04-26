<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfparcela extends Model
{
    protected $table = 'sfparcela';

    protected $fillable = [
        'sfcronbaixapatrimonial_id',
        'numParcela',
        'dtPrevista',
        'vlr',
    ];

    public function createFromXML(array $parcela)
    {
        $this->fill($parcela);
        $this->save();

        return $this;
    }
}
