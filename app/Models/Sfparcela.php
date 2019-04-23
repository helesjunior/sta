<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfparcela extends Model
{
    protected $table = 'sfparcela';

    protected $fillable = [
        'numParcela',
        'dtPrevista',
        'vlr',
    ];
}
