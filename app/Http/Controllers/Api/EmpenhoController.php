<?php

namespace App\Http\Controllers\Api;

use App\Models\Empenhodetalhado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Empenho;


class EmpenhoController extends Controller
{
    public function ler()
    {
        $path = config('app.path_pendentes');

        if (is_dir($path)) {
            $diretorio = dir($path);
            while (($a = $diretorio->read()) !== false) {
                $arquivos[] = $a;
            }
            $diretorio->close();
        } else {
            echo 'A pasta inexistente.';
        }
        asort($arquivos);

        $nomearquivo = [];

        foreach ($arquivos as $arq){
            $arq1 = explode('.',$arq);
            if($arq1[1]== 'TXT'){
                $nomearquivo[] = $arq1[0];
            }
        }

        if(count($nomearquivo)){
            foreach ($nomearquivo as $nome){
                if(substr($nome,0,2) == 'ne'){
                    $empenho = $this->lerArquivo($nome);

                    foreach ($empenho as $e) {
                        $busca = $this->buscaEmpenho($e['ug'], $e['gestao'], $e['numero']);
                        if (!count($busca)) {
                            $novo_empenho = new Empenho;
                            $novo_empenho->ug = $e['ug'];
                            $novo_empenho->gestao = $e['gestao'];
                            $novo_empenho->numero = $e['numero'];
                            $novo_empenho->numero_ref = $e['numero_ref'];
                            $novo_empenho->emissao = $e['emissao'];
                            $novo_empenho->tipofavorecido = $e['tipofavorecido'];
                            $novo_empenho->favorecido = $e['favorecido'];
                            $novo_empenho->observacao = $e['observacao'];
                            $novo_empenho->fonte = $e['fonte'];
                            $novo_empenho->naturezadespesa = $e['naturezadespesa'];
                            $novo_empenho->planointerno = $e['planointerno'];
                            $novo_empenho->num_lista = $e['num_lista'];
                            $novo_empenho->save();
                        }
                    }
                }

            }

            $ok = 'Empenhos lidos.';

        }else{
            $ok = 'Não Há arquivos para leitura.';
        }

        return $ok;

    }

    protected function buscaEmpenho($ug, $gestao, $numero)
    {

        $empenho = Empenho::where('ug', $ug)
            ->where('gestao', $gestao)
            ->where('numero', $numero)
            ->get();

        return $empenho;

    }

    public function lerArquivo($nomeaquivo)
    {
        $path = config('app.path_pendentes');
        $path_processados = config('app.path_processados');
        $name = $path . $nomeaquivo;
        $namedestino = $path_processados . $nomeaquivo;

        $myfile = gzopen($name . ".REF.gz", "r") or die("Unable to open file!");

        $i = 0;
        while (!gzeof($myfile)) {
            $line = gzgets($myfile);

            if (strlen($line) == 0) break;

            $ref[$i]['column'] = trim(substr($line, 0, 40));
            $ref[$i]['type'] = trim(substr($line, 40, 1));

            if (strstr(trim(substr($line, 42, 4)), ",") != FALSE) {
                $num = explode(",", trim(substr($line, 42, 4)));
                $ref[$i]['size'] = $num[0] + $num[1];
                $ref[$i]['decimal'] = $num[1];
            } else {
                $ref[$i]['size'] = trim(substr($line, 42, 4)) * 1;
                $ref[$i]['decimal'] = 0;
            }

            $ref[$i]['acu'] = ($i == 0) ? $ref[$i]['size'] : $ref[$i]['size'] + $ref[$i - 1]['acu'];
            $i++;
        }
        $NUMCOLS = $i;
        gzclose($myfile);

        if(copy($name.".REF.gz",$namedestino.".LIDO.REF.gz")){
            unlink($name.".REF.gz");
        }

        $myfile = gzopen($name . ".TXT.gz", "r") or die("Unable to open file!");
        $i = 0;
        $j = 0;
        while (!gzeof($myfile)) {
            $line = gzgets($myfile);
            for ($j = 0; $j < $NUMCOLS; $j++) {
                $campo = $ref[$j]['column'];
                $inicio = ($j == 0) ? 0 : $ref[$j - 1]['acu'];
                $valor = trim(substr($line, $inicio, $ref[$j]['size']));
                if ($ref[$j]['type'] == "N") {
                    $valor = $valor * pow(10, -$ref[$j]['decimal']);
                }
                if ($campo == 'GR-UG-GESTAO-AN-NUMERO-NEUQ(1)') {
                    $empenho[$i]['ug'] = substr($valor, 0, 6);
                    $empenho[$i]['gestao'] = substr($valor, 6, 5);
                    $empenho[$i]['numero'] = substr($valor, 11, 12);
                }
                if ($campo == 'GR-AN-NU-DOCUMENTO-REFERENCIA') {
                    $empenho[$i]['numero_ref'] = $valor;
                }
                if ($campo == 'IT-DA-EMISSAO') {
                    $empenho[$i]['emissao'] = substr($valor, 0, 4) . '-' . substr($valor, 4, 2) . '-' . substr($valor, 6, 2);
                }
                if ($campo == 'IT-IN-FAVORECIDO') {
                    $empenho[$i]['tipofavorecido'] = $valor;
                }
                if ($campo == 'IT-CO-FAVORECIDO') {
                    if($empenho[$i]['tipofavorecido'] == 4){
                        $empenho[$i]['favorecido'] = substr($valor,0,6);
                    }else{
                        $empenho[$i]['favorecido'] = $valor;
                    }
                }
                if ($campo == 'IT-TX-OBSERVACAO') {
                    $empenho[$i]['observacao'] = strtoupper(utf8_encode($valor));
                }
                if ($campo == 'GR-FONTE-RECURSO') {
                    $empenho[$i]['fonte'] = $valor;
                }
                if ($campo == 'GR-NATUREZA-DESPESA') {
                    $empenho[$i]['naturezadespesa'] = $valor;
                }
                if ($campo == 'IT-CO-PLANO-INTERNO') {
                    $empenho[$i]['planointerno'] = $valor;
                }
                if ($campo == 'IT-NU-LISTA(1)') {
                    $empenho[$i]['num_lista'] = $valor;
                }
            }

            if ($empenho[$i]['fonte'] == '' AND $empenho[$i]['naturezadespesa'] == '0') {
                unset($empenho[$i]);
            }
            $i++;
        }
        gzclose($myfile);

        if(copy($name.".TXT.gz",$namedestino.".LIDO.TXT.gz")){
            unlink($name.".TXT.gz");
        }
        return $empenho;
    }

    public function buscaEmpenhoPorNumero($dado){

        $ug = substr($dado,0,6);
        $gestao = substr($dado,6,5);
        $numempenho = strtoupper(substr($dado,11,12));
        $retorno = new \stdClass();

        $empenho = Empenho::where('ug',$ug)
            ->where('gestao',$gestao)
            ->where('numero',$numempenho)
            ->first();

        if(count($empenho)){

            $retorno->ug = $empenho->ug;
            $retorno->gestao = $empenho->gestao;
            $retorno->numero = $empenho->numero;
            $retorno->emissao = $empenho->emissao;
            $retorno->tipofavorecido = $empenho->tipofavorecido;
            $retorno->favorecido = $empenho->favorecido;
            $retorno->observacao = $empenho->observacao;
            $retorno->fonte = $empenho->fonte;
            $retorno->naturezadespesa = $empenho->naturezadespesa;
            $retorno->planointerno = $empenho->planointerno;

            $empenhodetalhado = Empenhodetalhado::where('ug',$empenho->ug)
                ->where('gestao', $empenho->gestao)
                ->where('numeroli', $empenho->num_lista)
                ->orderBy('numitem')
                ->get();

            if(count($empenhodetalhado)){

                $empdetalhado = [];

                foreach($empenhodetalhado as $empd){

                    $empdetalhado[$empd->numitem]['subitem']  = $empd->subitem;
                    $empdetalhado[$empd->numitem]['quantidade'] = $empd->quantidade;
                    $empdetalhado[$empd->numitem]['descricao'] = $empd->descricao;
                    $empdetalhado[$empd->numitem]['valorunitario'] = $empd->valorunitario;
                    $empdetalhado[$empd->numitem]['valortotal'] = $empd->valortotal;

                }

                $retorno->itens = $empdetalhado;

            }
        }

        return json_encode($retorno);

    }



}
