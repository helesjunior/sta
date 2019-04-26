<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SimpleXMLElement;

class Sfpadrao extends Model
{
    protected $table = 'sfpadrao';

    protected $fillable = [
        'codUgEmit',
        'anoDH',
        'codTipoDH',
        'numDH',
    ];

    public function createFromXml(array $dado)
    {

        try {
            \DB::beginTransaction();

            $this->fill($dado);
            $this->save();

            $this->createDadosBasicosFromXml($dado);
            $this->createPcoFromXml($dado);
            $this->createPsoFromXml($dado);
            $this->createDeducaoFromXml($dado);
            $this->createEncargoFromXml($dado);


            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
            throw $exception;
        }


        return $this;
    }

    private function createDadosBasicosFromXml(array $dado)
    {
        if (!isset($dado['dadosBasicos'])) {
            return;
        }

        $dadosbasicos = $dado['dadosBasicos'];

        $dadosbasicos['sfpadrao_id'] = $this->id;
        $sfdadosbasicos = new Sfdadosbasicos;
        $sfdadosbasicos->createFromXml($dadosbasicos);

    }

    private function createDeducaoFromXml(array $dado)
    {
        if (!isset($dado['deducao'])) {
            return;
        }

        $deducoes = isset($dado['deducao'][0]) ? $dado['deducao'] : [$dado['deducao']];

        foreach ($deducoes as $deducao) {
            $deducao['sfpadrao_id'] = $this->id;
            $sfdeducao = new Sfdeducao;
            $sfdeducao->createFromXml($deducao);
        }

    }

    private function createEncargoFromXml(array $dado)
    {
        if (!isset($dado['encargo'])) {
            return;
        }

        $encargos = isset($dado['encargo'][0]) ? $dado['encargo'] : [$dado['encargo']];

        foreach ($encargos as $encargo) {
            $encargo['sfpadrao_id'] = $this->id;
            $sfencargo = new Sfencargo;
            $sfencargo->createFromXml($encargo);
        }

    }

    private function createPcoFromXml(array $dado)
    {
        if (!isset($dado['pco'])) {
            return;
        }

        $pcos = isset($dado['pco'][0]) ? $dado['pco'] : [$dado['pco']];

        foreach ($pcos as $pco) {
            $pco['sfpadrao_id'] = $this->id;
            $sfpco = new Sfpco;
            $sfpco->createFromXml($pco);
        }

    }

    private function createPsoFromXml(array $dado)
    {
        if (!isset($dado['pso'])) {
            return;
        }

        $psos = isset($dado['pso'][0]) ? $dado['pso'] : [$dado['pso']];

        foreach ($psos as $pso) {
            $pso['sfpadrao_id'] = $this->id;
            $sfpso = new Sfpso;
            $sfpso->createFromXml($pso);
        }

    }


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
