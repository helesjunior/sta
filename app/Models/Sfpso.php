<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpso extends Model
{
    protected $table = 'sfpso';

    public function psoItem()
    {
        return $this->hasMany(Sfpsoitem::class);
    }

}
