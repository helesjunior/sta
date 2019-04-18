<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdadosbasicos extends Model
{
    protected $table = 'sfdadosbasicos';

    protected $fillable = [
        'dtEmis',
        'dtVenc',
        'codUgPgto',
        'vlr',
        'txtObser',
        'txtInfoAdic',
        'vlrTaxaCambio',
        'txtProcesso',
        'dtAteste',
        'codCredorDevedor',
        'dtPgtoReceb',
    ];

    public function docOrigem()
    {
        return $this->hasMany(Sfdocorigem::class);
    }

    public function docRelacionado()
    {
        return $this->hasMany(Sfdocrelacionado::class);
    }

    public function tramite()
    {
        return $this->hasMany(Sftramite::class);
    }
}
