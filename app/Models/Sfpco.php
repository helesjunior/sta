<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpco extends Model
{
    protected $table = 'sfpco';

    protected $fillable = [
        'numSeqItem',
        'codSit',
        'codUgEmpe',
        'indrTemContrato',
        'txtInscrD',
        'numClassD',
        'txtInscrE',
        'numClassE',
    ];

    public function pcoItem()
    {
        return $this->hasMany(Sfpcoitem::class);
    }

    public function cronBaixaPatrimonial()
    {
        return $this->morphOne(Sfcronbaixapatrimonial::class, 'sfcronbaixapatrimonialable');
    }

}
