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

        try{
            \DB::beginTransaction();

            $this->fill($dado);
            $this->save();

            $this->createDeducaoFromXml($dado);

//        if (isset($dado->dadosBasicos)) {
//            $sfdadosbasicos = new SfdadosbasicosController;
//            $sfpadrao = $sfdadosbasicos->inserirSfdadosBasicos($dado,$sfpadrao);
//        }
//
//        if (isset($dado->pco)) {
//            $sfpco = new SfpcoController;
//            $sfpadrao = $sfpco->inserirSfpco($dado,$sfpadrao);
//        }
//
//        if (isset($dado->pso)) {
//            $sfpso = new SfpsoController;
//            $sfpadrao = $sfpso->inserirSfpso($dado,$sfpadrao);
//        }
//
//        if (isset($dado->credito)) {
//            $sfcredito = new SfcreditoController;
//            $sfpadrao = $sfcredito->inserirSfcredito($dado,$sfpadrao);
//        }
//
//        if (isset($dado->outrosLanc)) {
//            $sfoutroslanc = new SfoutroslancController;
//            $sfpadrao = $sfoutroslanc->inserirSfoutrosLanc($dado,$sfpadrao);
//        }
//
            \DB::commit();
        }catch (\Exception $exception){
            \DB::rollBack();
            throw $exception;
        }


        return $this;
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
