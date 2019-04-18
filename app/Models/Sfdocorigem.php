<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdocorigem extends Model
{
    protected $table = 'sfdocorigem';

    protected $fillable = [
        'codIdentEmit',
        'dtEmis',
        'numDocOrigem',
        'vlr',
    ];

}
