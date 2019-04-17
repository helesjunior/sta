<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdespesaanular extends Model
{
    protected $table = 'sfdespesaanular';

    public function despesaAnularItem()
    {
        return $this->hasMany(Sfdespesaanularitem::class);
    }

}
