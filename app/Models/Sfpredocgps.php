<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpredocgps extends Model
{
    protected $table = 'sfpredocgps';

    protected $fillable = [
        'sfpredoc_id',
        'codRecurso',
        'txtProcesso',
        'mesCompet',
        'anoCompet',
        'indrAdiant13',
    ];


    public function createFromXML(array $predocgps)
    {
        $this->fill($predocgps);
        $this->save();

        return $this;
    }

}
