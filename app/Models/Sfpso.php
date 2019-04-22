<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpso extends Model
{
    protected $table = 'sfpso';


    protected $fillable = [
        'numSeqItem',
        'codSit',
        'txtInscrE',
        'numClassE',
        'txtInscrF',
        'numClassF',
    ];

    public function psoItens()
    {
        return $this->hasMany(Sfpsoitem::class);
    }

}
