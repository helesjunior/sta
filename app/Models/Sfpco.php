<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpco extends Model
{
    protected $table = 'sfpco';

    public function pcoItem()
    {
        return $this->hasMany(Sfpcoitem::class);
    }

    public function cronBaixaPatrimonial()
    {
        return $this->morphOne(Sfcronbaixapatrimonial::class, 'sfcronbaixapatrimonialable');
    }

}
