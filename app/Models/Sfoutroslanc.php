<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfoutroslanc extends Model
{
    protected $table = 'sfoutroslanc';

    public function cronBaixaPatrimonial()
    {
        return $this->morphOne(Sfcronbaixapatrimonial::class, 'sfcronbaixapatrimonialable');
    }

}
