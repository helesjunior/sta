<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdadosbasicos extends Model
{
    protected $table = 'sfdadosbasicos';

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
