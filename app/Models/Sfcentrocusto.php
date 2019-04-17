<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfcentrocusto extends Model
{
    protected $table = 'sfcentrocusto';

    public function relPcoItem()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalorable');
    }

    public function relOutrosLanc()
    {
        return $this->morphMany(Sfrelsemitemvalor::class, 'sfrelsemitemvalorable');
    }

    public function relOutrosLancCronogramaPatrimonial()
    {
        return $this->morphMany(Sfrelsemitemvalor::class, 'sfrelsemitemvalorable');
    }

    public function relPsoItem()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalorable');
    }

    public function relEncargo()
    {
        return $this->morphMany(Sfrelsemitemvalor::class, 'sfrelsemitemvalorable');
    }

    public function relAcrescimoDeducao()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalorable');
    }

    public function relAcrescimoEncargo()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalorable');
    }

    public function relAcrescimoDadosPag()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalorable');
    }

    public function relDespesaAntecipada()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalorable');
    }

    public function relDespesaAnular()
    {
        return $this->morphMany(Sfrelcomitemvalor::class, 'sfrelcomitemvalorable');
    }

}
