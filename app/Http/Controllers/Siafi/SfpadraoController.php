<?php

namespace App\Http\Controllers\Siafi;

use App\Models\Sfpadrao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SfpadraoController extends Controller
{
    public function buscaSfpadrao($dado)
    {
        $sfpadrao = Sfpadrao::where('codUgEmit', $dado->codUgEmit)
            ->where('anoDH', $dado->anoDH)
            ->where('codTipoDH', $dado->codTipoDH)
            ->where('numDH', $dado->numDH)
            ->first();;

        return $sfpadrao;

    }

    /**
     * @param $dado
     * @return Sfpadrao
     */
    public function inserirSfpadrao($dado)
    {
        $sfpadrao = new Sfpadrao;

        $sfpadrao->codUgEmit = $dado->codUgEmit;
        $sfpadrao->anoDH = $dado->anoDH;
        $sfpadrao->codTipoDH = $dado->codTipoDH;
        $sfpadrao->numDH = $dado->numDH;
        $sfpadrao->save();


        $sfpadrao->dadosBasicos()->create([
            'dtEmis' => $dado->dadosBasicos->dtEmis ?? null,
            'dtVenc' => $dado->dadosBasicos->dtVenc ?? null,
            'codUgPgto' => $dado->dadosBasicos->codUgPgto,
            'vlr' => $dado->dadosBasicos->vlr,
            'txtObser' => $dado->dadosBasicos->txtObser,
            'txtInfoAdic' => $dado->dadosBasicos->txtInfoAdic,
            'vlrTaxaCambio' => $dado->dadosBasicos->vlrTaxaCambio,
            'txtProcesso' => $dado->dadosBasicos->txtProcesso,
            'dtAteste' => $dado->dadosBasicos->dtAteste ?? null,
            'codCredorDevedor' => $dado->dadosBasicos->codCredorDevedor,
            'dtPgtoReceb' => $dado->dadosBasicos->dtPgtoReceb ?? null,
        ]);

        if (isset($dado->dadosBasicos->docOrigem)) {
            foreach ($dado->dadosBasicos->docOrigem as $docorigem) {
                $sfpadrao->dadosBasicos->docOrigem()->create([
                    'codIdentEmit' => $docorigem->codIdentEmit,
                    'dtEmis' => $docorigem->dtEmis ?? null,
                    'numDocOrigem' => $docorigem->numDocOrigem,
                    'vlr' => $docorigem->vlr,
                ]);
            }
        }

        if (isset($dado->dadosBasicos->docRelacionado)) {
            foreach ($dado->dadosBasicos->docRelacionado as $docrelacionado) {
                $sfpadrao->dadosBasicos->docRelacionado()->create([
                    'codUgEmit' => $docrelacionado->codUgEmit,
                    'numDocRelacionado' => $docrelacionado->numDocRelacionado,
                ]);
            }
        }

        if (isset($dado->dadosBasicos->tramite)) {
            foreach ($dado->dadosBasicos->tramite as $tramite) {
                $sfpadrao->dadosBasicos->docRelacionado()->create([
                    'txtLocal' => $tramite->txtLocal,
                    'dtEntrada' => $tramite->dtEntrada,
                    'DtSaida' => $tramite->DtSaida,
                ]);
            }
        }

        if (isset($dado->pco)) {
            foreach ($dado->pco as $pco) {
                $sfpadrao->pco()->create([
                    'numSeqItem' => $pco->numSeqItem,
                    'codSit' => $pco->codSit,
                    'codUgEmpe' => $pco->codUgEmpe,
                    'indrTemContrato' => $pco->indrTemContrato,
                    'txtInscrD' => $pco->txtInscrD,
                    'numClassD' => $pco->numClassD ?? null,
                    'txtInscrE' => $pco->txtInscrE,
                    'numClassE' => $pco->numClassE ?? null,
                ]);
            }
        }

        if (isset($dado->pco->pcoItem)) {
            foreach ($dado->pco->pcoItem as $pcoitem) {
                foreach ($sfpadrao->pco as $pco)
                {
                    $pco->pcoItens()->create([
                        'numSeqItem' => $pcoitem->numSeqItem,
                        'numEmpe' => $pcoitem->numEmpe,
                        'codSubItemEmpe' => $pcoitem->codSubItemEmpe ?? null,
                        'indrLiquidado' => $pcoitem->indrLiquidado,
                        'vlr' => $pcoitem->vlr,
                        'txtInscrA' => $pcoitem->txtInscrA,
                        'numClassA' => $pcoitem->numClassA ?? null,
                        'txtInscrB' => $pcoitem->txtInscrB,
                        'numClassB' => $pcoitem->numClassB ?? null,
                        'txtInscrC' => $pcoitem->txtInscrC,
                        'numClassC' => $pcoitem->numClassC ?? null,
                    ]);
                }

            }
        }

        if (isset($dado->pco->cronBaixaPatrimonial)) {
            foreach ($dado->pco->cronBaixaPatrimonial->parcela as $parcela) {
                foreach ($sfpadrao->pco as $pco)
                {
                    $pco->cronBaixaPatrimonial->parcelas()->create([
                        'numParcela' => $parcela->numParcela,
                        'dtPrevista' => $parcela->dtPrevista,
                        'vlr' => $parcela->vlr,
                    ]);
                }
            }
        }

        if (isset($dado->pso)) {
            foreach ($dado->pso as $pso) {
                $sfpadrao->pso()->create([
                    'numSeqItem' => $pso->numSeqItem,
                    'codSit' => $pso->codSit,
                    'txtInscrE' => $pso->txtInscrE,
                    'numClassE' => $pso->numClassE ?? null,
                    'txtInscrF' => $pso->txtInscrF,
                    'numClassF' => $pso->numClassF ?? null,
                ]);
            }
        }

        if (isset($dado->pso->psoItem)) {
            foreach ($dado->pso->psoItem as $psoitem) {
                foreach ($sfpadrao->pso as $pso)
                {
                    $pso->psoItens()->create([
                        'numSeqItem' => $psoitem->numSeqItem,
                        'indrLiquidado' => $psoitem->indrLiquidado ?? null,
                        'vlr' => $psoitem->vlr,
                        'codFontRecur' => $psoitem->codFontRecur ?? null,
                        'codCtgoGasto' => $psoitem->codCtgoGasto,
                        'txtInscrA' => $psoitem->txtInscrA,
                        'numClassA' => $psoitem->numClassA ?? null,
                        'txtInscrB' => $psoitem->txtInscrB,
                        'numClassB' => $psoitem->numClassB ?? null,
                        'txtInscrC' => $psoitem->txtInscrC,
                        'numClassC' => $psoitem->numClassC ?? null,
                        'txtInscrD' => $psoitem->txtInscrD,
                        'numClassD' => $psoitem->numClassD ?? null,
                    ]);
                }

            }
        }


        if (isset($dado->credito)) {
            foreach ($dado->credito as $credito) {
                $sfpadrao->credito()->create([
                    'numSeqItem' => $credito->numSeqItem,
                    'codSit' => $credito->codSit,
                    'indrLiquidado' => $credito->indrLiquidado ?? null,
                    'vlr' => $credito->vlr,
                    'codFontRecur' => $credito->codFontRecur ?? null,
                    'codCtgoGasto' => $credito->codCtgoGasto,
                    'txtInscrA' => $credito->txtInscrA,
                    'numClassA' => $credito->numClassA ?? null,
                    'txtInscrB' => $credito->txtInscrB,
                    'numClassB' => $credito->numClassB ?? null,
                    'txtInscrC' => $credito->txtInscrC,
                    'numClassF' => $credito->numClassF ?? null,
                ]);
            }
        }


        if (isset($dado->outrosLanc)) {
            foreach ($dado->outrosLanc as $outrosLanc) {
                $sfpadrao->outrosLanc()->create([
                    'numSeqItem' => $outrosLanc->numSeqItem,
                    'codSit' => $outrosLanc->codSit,
                    'indrLiquidado' => $outrosLanc->indrLiquidado ?? null,
                    'vlr' => $outrosLanc->vlr,
                    'indrTemContrato' => $outrosLanc->indrTemContrato ?? null,
                    'txtInscrA' => $outrosLanc->txtInscrA,
                    'numClassA' => $outrosLanc->numClassA ?? null,
                    'txtInscrB' => $outrosLanc->txtInscrB,
                    'numClassB' => $outrosLanc->numClassB ?? null,
                    'txtInscrC' => $outrosLanc->txtInscrC,
                    'numClassC' => $outrosLanc->numClassC ?? null,
                    'txtInscrD' => $outrosLanc->txtInscrD,
                    'numClassD' => $outrosLanc->numClassD ?? null,
                    'tpNormalEstorno' => $outrosLanc->tpNormalEstorno,
                ]);
            }
        }

        if (isset($dado->outrosLanc->cronBaixaPatrimonial)) {
            foreach ($dado->outrosLanc->cronBaixaPatrimonial->parcela as $parcela) {
                foreach ($sfpadrao->outrosLanc as $outrosLanc)
                {
                    $outrosLanc->cronBaixaPatrimonial->parcelas()->create([
                        'numParcela' => $parcela->numParcela,
                        'dtPrevista' => $parcela->dtPrevista,
                        'vlr' => $parcela->vlr,
                    ]);
                }
            }
        }

        if (isset($dado->deducao)) {
            foreach ($dado->deducao as $deducao) {
                $sfpadrao->deducao()->create([
                    'numSeqItem' => $deducao->numSeqItem,
                    'codSit' => $deducao->codSit,
                    'dtVenc' => $deducao->dtVenc ?? null,
                    'dtPgtoReceb' => $deducao->dtPgtoReceb ?? null,
                    'codUgPgto' => $deducao->codUgPgto ?? null,
                    'vlr' => $deducao->vlr,
                    'txtInscrA' => $deducao->txtInscrA,
                    'numClassA' => $deducao->numClassA ?? null,
                    'txtInscrB' => $deducao->txtInscrB,
                    'numClassB' => $deducao->numClassB ?? null,
                    'txtInscrC' => $deducao->txtInscrC,
                    'numClassC' => $deducao->numClassC ?? null,
                    'txtInscrD' => $deducao->txtInscrD,
                    'numClassD' => $deducao->numClassD ?? null,
                ]);
            }
        }

        if (isset($dado->deducao->itemRecolhimento)) {
            foreach ($dado->deducao->itemRecolhimento as $itemRecolhimento) {
                foreach ($sfpadrao->deducao as $deducao)
                {
                    $deducao->itemRecolhimento()->create([
                        'numSeqItem' => $itemRecolhimento->numSeqItem,
                        'codRecolhedor' => $itemRecolhimento->codRecolhedor,
                        'vlr' => $itemRecolhimento->vlr,
                        'vlrBaseCalculo' => $itemRecolhimento->vlrBaseCalculo,
                        'vlrMulta' => $itemRecolhimento->vlrMulta,
                        'vlrJuros' => $itemRecolhimento->vlrJuros,
                        'vlrOutrasEnt' => $itemRecolhimento->vlrOutrasEnt,
                        'vlrAtmMultaJuros' => $itemRecolhimento->vlrAtmMultaJuros,
                    ]);
                }

            }
        }

        if (isset($dado->deducao->predoc)) {
            foreach ($dado->deducao->predoc as $predoc) {
                foreach ($sfpadrao->deducao as $deducao)
                {
                    $deducao->predoc()->create([
                        'txtObser' => $predoc->txtObser,
                    ]);
                }

            }
        }

        if (isset($dado->deducao->predoc->predocOB)) {
            foreach ($dado->deducao->predoc->predocOB as $predocOb) {
                foreach ($sfpadrao->deducao as $deducao)
                {
                    $deducao->predoc->predocOb()->create([
                        'codTipoOB' => $predocOb->codTipoOB,
                        'codCredorDevedor' => $predocOb->codCredorDevedor,
                        'codNumLista' => $predocOb->codNumLista,
                        'txtCit' => $predocOb->txtCit,
                        'codRecoGru' => $predocOb->codRecoGru ?? null,
                        'codUgRaGru' => $predocOb->codUgRaGru ?? null,
                        'numRaGru' => $predocOb->numRaGru,
                        'codRecDarf' => $predocOb->codRecDarf ?? null,
                        'numRefDarf' => $predocOb->numRefDarf ?? null,
                        'codContRepas' => $predocOb->codContRepas ?? null,
                        'codEvntBacen' => $predocOb->codEvntBacen,
                        'codFinalidade' => $predocOb->codFinalidade ?? null,
                        'txtCtrlOriginal' => $predocOb->txtCtrlOriginal,
                        'vlrTaxaCambio' => $predocOb->vlrTaxaCambio ?? null,
                        'txtProcesso' => $predocOb->txtProcesso,
                        'codDevolucaoSPB' => $predocOb->codDevolucaoSPB ?? null,
                    ]);
                }
            }
        }


        return $sfpadrao;

    }

    public function atualizaSfpadrao($dado)
    {
        $sfpadrao = new Sfpadrao;

        $sfpadrao->codUgEmit = $dado->codUgEmit;
        $sfpadrao->anoDH = $dado->anoDH;
        $sfpadrao->codTipoDH = $dado->codTipoDH;
        $sfpadrao->numDH = $dado->numDH;
        $sfpadrao->save();

        return $sfpadrao;

    }
}
