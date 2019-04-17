<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdespesaanularitem extends Model
{
    protected $table = 'sfdespesaanularitem';

    public function relEncargo()
    {
        return $this->morphMany(Sfrelsemitem::class, 'sfrelsemitemable');
    }
}
