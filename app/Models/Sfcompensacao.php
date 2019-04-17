<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfcompensacao extends Model
{
    protected $table = 'sfcompensacao';

    public function relDeducaoItem()
    {
        return $this->morphMany(Sfrelsemitem::class, 'sfrelsemitemable');
    }

    public function relEncargoItem()
    {
        return $this->morphMany(Sfrelsemitem::class, 'sfrelsemitemable');
    }
}
