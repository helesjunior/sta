<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfdadospgto extends Model
{
    protected $table = 'sfdadospgto';

    public function itemRecolhimento()
    {
        return $this->morphMany(Sfitemrecolhimento::class, 'sfitemrecolhimentoable');
    }

    public function predoc()
    {
        return $this->morphOne(Sfpredoc::class, 'sfpredocable');
    }

    public function acrescimo()
    {
        return $this->morphMany(Sfacrescimo::class, 'sfacrescimoable');
    }
}
