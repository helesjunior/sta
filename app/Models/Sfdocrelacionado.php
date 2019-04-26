<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdocrelacionado extends Model
{
    protected $table = 'sfdocrelacionado';

    protected $fillable = [
        'sfdadosbasicos_id',
        'codUgEmit',
        'numDocRelacionado',
    ];

    public function createFromXml(array $dado)
    {
        $this->fill($dado);
        $this->save();

        return $this;
    }

}
