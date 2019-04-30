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

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($sfpadrao) {
            if (isset($sfpadrao->deducao)) {
                foreach ($sfpadrao->deducao as $deducao) {
                    $sfdeducao = new Sfdeducao();
                    if (isset($deducao->itemRecolhimento)) {
                        $sfdeducao->deleteItemRecolhimento($deducao);
                    }
                    if (isset($deducao->predoc)) {
                        $sfdeducao->deletepredoc($deducao);
                    }
                    if (isset($deducao->relPcoItem)) {
                        $sfdeducao->deleterelPcoItem($deducao);
                    }
                    if (isset($deducao->relPsoItem)) {
                        $sfdeducao->deleterelPsoItem($deducao);
                    }
                    if (isset($deducao->relCredito)) {
                        $sfdeducao->deleterelCredito($deducao);
                    }
                    if (isset($deducao->acrescimo)) {
                        $sfdeducao->deleteAcrescimo($deducao);
                    }
                }
            }

            if (isset($sfpadrao->pco)) {
                foreach ($sfpadrao->pco as $pco) {
                    if (isset($pco->cronBaixaPatrimonial)) {
                        $sfcronBaixaPatrimonial = new Sfcronbaixapatrimonial();
                        $sfcronBaixaPatrimonial->deleteParcela($pco->cronBaixaPatrimonial);
                    }
                }
            }

            if (isset($sfpadrao->outrosLanc)) {
                foreach ($sfpadrao->outrosLanc as $outrosLanc) {
                    if (isset($outrosLanc->cronBaixaPatrimonial)) {
                        $sfcronBaixaPatrimonial = new Sfcronbaixapatrimonial();
                        $sfcronBaixaPatrimonial->deleteParcela($outrosLanc->cronBaixaPatrimonial);
                    }
                }
            }

            if (isset($sfpadrao->encargo)) {
                foreach ($sfpadrao->encargo as $encargo) {
                    $sfencargo = new Sfencargo();
                    if (isset($encargo->itemRecolhimento)) {
                        $sfencargo->deleteItemRecolhimento($encargo);
                    }
                    if (isset($encargo->predoc)) {
                        $sfencargo->deletepredoc($encargo);
                    }
                    if (isset($encargo->acrescimo)) {
                        $sfencargo->deleteAcrescimo($encargo);
                    }
                }
            }

            if (isset($sfpadrao->dadosPgto)) {
                foreach ($sfpadrao->dadosPgto as $dadosPgto) {
                    $sfdadosPgto = new Sfdadospgto();
                    if (isset($dadosPgto->itemRecolhimento)) {
                        $sfdadosPgto->deleteItemRecolhimento($dadosPgto);
                    }
                    if (isset($dadosPgto->predoc)) {
                        $sfdadosPgto->deletepredoc($dadosPgto);
                    }
                    if (isset($dadosPgto->acrescimo)) {
                        $sfdadosPgto->deleteAcrescimo($dadosPgto);
                    }
                }
            }

            if (isset($sfpadrao->despesaAnular)) {
                foreach ($sfpadrao->despesaAnular as $despesaAnular) {
                    if (isset($despesaAnular->despesaAnularItem)) {
                        foreach ($despesaAnular->despesaAnularItem as $despesaAnularItem) {
                            if (isset($despesaAnularItem->relEncargo)) {
                                $sfdespesaanularitem = new Sfdespesaanularitem();
                                $sfdespesaanularitem->deleterelEncargo($despesaAnularItem);
                            }

                        }
                    }
                }
            }

            if (isset($sfpadrao->compensacao)) {
                foreach ($sfpadrao->compensacao as $compensacao) {
                    $sfcompensacao = new Sfcompensacao();
                    if (isset($despesaAnular->relDeducaoItem)) {
                        $sfcompensacao->deleterelDeducaoItem($compensacao);
                    }
                    if (isset($despesaAnular->relEncargoItem)) {
                        $sfcompensacao->deleterelEncargoItem($compensacao);
                    }
                }
            }

            if (isset($sfpadrao->centroCusto)) {
                foreach ($sfpadrao->centroCusto as $centroCusto) {
                    $sfcentroCusto = new Sfcentrocusto();
                    if (isset($centroCusto->relPcoItem)) {
                        $sfcentroCusto->deleterelPcoItem($centroCusto);
                    }
                    if (isset($centroCusto->relOutrosLanc)) {
                        $sfcentroCusto->deleterelOutrosLanc($centroCusto);
                    }
                    if (isset($centroCusto->relOutrosLancCronogramaPatrimonial)) {
                        $sfcentroCusto->deleterelOutrosLancCronogramaPatrimonial($centroCusto);
                    }
                    if (isset($centroCusto->relPsoItem)) {
                        $sfcentroCusto->deleterelPsoItem($centroCusto);
                    }
                    if (isset($centroCusto->relEncargo)) {
                        $sfcentroCusto->deleterelEncargo($centroCusto);
                    }
                    if (isset($centroCusto->relAcrescimoDeducao)) {
                        $sfcentroCusto->deleterelAcrescimoDeducao($centroCusto);
                    }
                    if (isset($centroCusto->relAcrescimoEncargo)) {
                        $sfcentroCusto->deleterelAcrescimoEncargo($centroCusto);
                    }
                    if (isset($centroCusto->relAcrescimoDadosPag)) {
                        $sfcentroCusto->deleterelAcrescimoDadosPag($centroCusto);
                    }
                    if (isset($centroCusto->relDespesaAntecipada)) {
                        $sfcentroCusto->deleterelDespesaAntecipada($centroCusto);
                    }

                    if (isset($centroCusto->relDespesaAnular)) {
                        $sfcentroCusto->deleterelDespesaAnular($centroCusto);
                    }

                }
            }


        });

    }

    public function createFromXml(array $dado)
    {
        $this->buscaSfpadrao($dado);

        $this->fill($dado);
        $this->save();

        $this->createDadosBasicosFromXml($dado);
        $this->createPcoFromXml($dado);
        $this->createPsoFromXml($dado);
        $this->createCreditoFromXml($dado);
        $this->createOustrosLancFromXml($dado);
        $this->createDeducaoFromXml($dado);
        $this->createEncargoFromXml($dado);
        $this->createDespesaAnularFromXml($dado);
        $this->createCompensacaoFromXml($dado);
        $this->createCentroCustoFromXml($dado);
        $this->createDadosPagtoFromXml($dado);
        $this->createDocContabilizacaoFromXml($dado);

//        try {
//            \DB::beginTransaction();
//
//            \DB::commit();
//        } catch (\Exception $exception) {
//            \DB::rollBack();
//            throw $exception;
//        }


        return $this;
    }

    private function buscaSfpadrao($dado)
    {
        $sfpadrao = $this->where('codUgEmit', $dado['codUgEmit'])
            ->where('anoDH', $dado['anoDH'])
            ->where('codTipoDH', $dado['codTipoDH'])
            ->where('numDH', $dado['numDH'])
            ->first();

        if (count($sfpadrao)) {
            $sfpadrao->delete();
        }
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

    private function createCreditoFromXml(array $dado)
    {
        if (!isset($dado['credito'])) {
            return;
        }

        $creditos = isset($dado['credito'][0]) ? $dado['credito'] : [$dado['credito']];

        foreach ($creditos as $credito) {
            $credito['sfpadrao_id'] = $this->id;
            $sfcredito = new Sfcredito;
            $sfcredito->createFromXml($credito);
        }

    }

    private function createOustrosLancFromXml(array $dado)
    {
        if (!isset($dado['outrosLanc'])) {
            return;
        }

        $outrosLancs = isset($dado['outrosLanc'][0]) ? $dado['outrosLanc'] : [$dado['outrosLanc']];

        foreach ($outrosLancs as $outrosLanc) {
            $outrosLanc['sfpadrao_id'] = $this->id;
            $sfoutrosLanc = new Sfoutroslanc;
            $sfoutrosLanc->createFromXml($outrosLanc);
        }

    }

    private function createDespesaAnularFromXml(array $dado)
    {
        if (!isset($dado['despesaAnular'])) {
            return;
        }

        $despesaAnulars = isset($dado['despesaAnular'][0]) ? $dado['despesaAnular'] : [$dado['despesaAnular']];

        foreach ($despesaAnulars as $despesaAnular) {
            $despesaAnular['sfpadrao_id'] = $this->id;
            $sfdespesaAnular = new Sfdespesaanular;
            $sfdespesaAnular->createFromXml($despesaAnular);
        }

    }

    private function createCompensacaoFromXml(array $dado)
    {
        if (!isset($dado['compensacao'])) {
            return;
        }

        $compensacaos = isset($dado['compensacao'][0]) ? $dado['compensacao'] : [$dado['compensacao']];

        foreach ($compensacaos as $compensacao) {
            $compensacao['sfpadrao_id'] = $this->id;
            $sfcompensacao = new Sfcompensacao;
            $sfcompensacao->createFromXml($compensacao);
        }

    }

    private function createCentroCustoFromXml(array $dado)
    {
        if (!isset($dado['centroCusto'])) {
            return;
        }

        $centroCustos = isset($dado['centroCusto'][0]) ? $dado['centroCusto'] : [$dado['centroCusto']];

        foreach ($centroCustos as $centroCusto) {
            $centroCusto['sfpadrao_id'] = $this->id;
            $sfcentroCusto = new Sfcentrocusto;
            $sfcentroCusto->createFromXml($centroCusto);
        }

    }

    private function createDadosPagtoFromXml(array $dado)
    {
        if (!isset($dado['dadosPgto'])) {
            return;
        }

        $dadosPgtos = isset($dado['dadosPgto'][0]) ? $dado['dadosPgto'] : [$dado['dadosPgto']];

        foreach ($dadosPgtos as $dadosPgto) {
            $dadosPgto['sfpadrao_id'] = $this->id;
            $sfdadosPgto = new Sfdadospgto;
            $sfdadosPgto->createFromXml($dadosPgto);
        }

    }

    private function createDocContabilizacaoFromXml(array $dado)
    {
        if (!isset($dado['docContabilizacao'])) {
            return;
        }

        $docContabilizacaos = isset($dado['docContabilizacao'][0]) ? $dado['docContabilizacao'] : [$dado['docContabilizacao']];

        foreach ($docContabilizacaos as $docContabilizacao) {
            $docContabilizacao['sfpadrao_id'] = $this->id;
            $sfdocContabilizacao = new Sfdoccontabilizacao;
            $sfdocContabilizacao->createFromXml($docContabilizacao);
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
