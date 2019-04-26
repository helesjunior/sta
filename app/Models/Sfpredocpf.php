<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocpf extends Model
{
    protected $table = 'sfpredocpf';

    protected $fillable = [
        'sfpredoc_id',
        'codUGFavorecida',
        'vinculacaoPgto',
        'txtInscrA',
        'numClassA',
        'txtInscrB',
        'numClassB',
        'txtInscrC',
        'txtInscrD',
    ];

    public function createFromXML(array $predocgru)
    {
        $this->fill($predocgru);
        $this->save();

        return $this;
    }
}
