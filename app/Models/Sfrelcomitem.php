<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfrelcomitem extends Model
{
    protected $table = 'sfrelcomitem';

    protected $fillable = [
        'numSeqPai',
        'numSeqItem',
    ];


    public function createFromXML(array $dado)
    {
        $this->fill($dado);
        if(isset($dado['morphpco'])){
            $this->sfrelcomitempcoable()->associate($dado['morphpco']);
        }
        if(isset($dado['morphpso'])){
            $this->sfrelcomitempsoable()->associate($dado['morphpso']);
        }
        $this->save();
    }


    public function sfrelcomitempcoable()
    {
        return $this->morphTo();
    }

    public function sfrelcomitempsoable()
    {
        return $this->morphTo();
    }
}
