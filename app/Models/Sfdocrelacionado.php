<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdocrelacionado extends Model
{
    protected $table = 'sfdocrelacionado';

    protected $fillable = [
        'codUgEmit',
        'numDocRelacionado',
    ];

}
