<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sfpadrao extends Model
{
    protected $table = 'sfpadrao';

    public function dadosBasicos()
    {
        return $this->hasOne(Sfdadosbasicos::class);
    }

    public function pco()
    {
        return $this->hasMany(Sfpco::class);
    }

    public function pso()
    {
        return $this->hasMany(Sfpso::class);
    }

    public function credito()
    {
        return $this->hasMany(Sfcredito::class);
    }

    public function outrosLanc()
    {
        return $this->hasMany(Sfoutroslanc::class);
    }

    public function deducao()
    {
        return $this->hasMany(Sfdeducao::class);
    }

    public function encargo()
    {
        return $this->hasMany(Sfencargo::class);
    }

    public function despesaAnular()
    {
        return $this->hasMany(Sfdespesaanular::class);
    }

    public function compensacao()
    {
        return $this->hasMany(Sfcompensacao::class);
    }

    public function centroCusto()
    {
        return $this->hasMany(Sfcentrocusto::class);
    }

    public function dadosPgto()
    {
        return $this->hasMany(Sfdadospgto::class);
    }

    public function docContabilizacao()
    {
        return $this->hasMany(Sfdoccontabilizacao::class);
    }
}
