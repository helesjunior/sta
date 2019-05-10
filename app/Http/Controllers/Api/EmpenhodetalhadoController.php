<?php

namespace App\Http\Controllers\Api;

use App\Models\Empenho;
use App\Models\Empenhodetalhado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmpenhodetalhadoController extends Controller
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

        foreach ($arquivos as $arq) {
            $arq1 = explode('.', $arq);
            if ($arq1[1] == 'TXT') {
                $nomearquivo[] = $arq1[0];
            }
        }

        if (count($nomearquivo)) {
            foreach ($nomearquivo as $nome) {
                if (substr($nome, 0, 5) == 'itens') {
                    $listaempenho = $this->lerArquivo($nome);

                    foreach ($listaempenho as $e) {
                        $busca = $this->buscaLista($e['ug'], $e['gestao'], $e['numeroli'], $e['numitem'],
                            $e['subitem']);
                        if (!count($busca)) {
                            $novo_listaempenho = new Empenhodetalhado;
                            $novo_listaempenho->ug = $e['ug'];
                            $novo_listaempenho->gestao = $e['gestao'];
                            $novo_listaempenho->numeroli = $e['numeroli'];
                            $novo_listaempenho->numitem = $e['numitem'];
                            $novo_listaempenho->subitem = $e['subitem'];
                            $novo_listaempenho->quantidade = $e['quantidade'];
                            $novo_listaempenho->valorunitario = $e['valorunitario'];
                            $novo_listaempenho->valortotal = $e['valortotal'];
                            $novo_listaempenho->descricao = $e['descricao'];
                            $novo_listaempenho->save();
                        }
                    }
                }

            }

            $ok = 'Empenhos Detalhados lidos.';

        } else {
            $ok = 'Não Há arquivos para leitura.';
        }

        return $ok;

    }

    protected function buscaLista($ug, $gestao, $numeroli, $numitem, $subitem)
    {

        $listaempenho = Empenhodetalhado::where('ug', $ug)
            ->where('gestao', $gestao)
            ->where('numeroli', $numeroli)
            ->where('numitem', $numitem)
            ->where('subitem', $subitem)
            ->get();

        return $listaempenho;

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

            if (strlen($line) == 0) {
                break;
            }

            $ref[$i]['column'] = trim(substr($line, 0, 40));
            $ref[$i]['type'] = trim(substr($line, 40, 1));

            if (strstr(trim(substr($line, 42, 4)), ",") != false) {
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

        if (copy($name . ".REF.gz", $namedestino . ".LIDO.REF.gz")) {
            unlink($name . ".REF.gz");
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
                if ($campo == 'GR-UG-GESTAO-AN-NUMERO-LI') {
                    $listaempenho[$i]['ug'] = substr($valor, 0, 6);
                    $listaempenho[$i]['gestao'] = substr($valor, 6, 5);
                    $listaempenho[$i]['numeroli'] = substr($valor, 11, 12);
                }
                if ($campo == 'IT-NU-ITEM') {
                    $listaempenho[$i]['numitem'] = str_pad($valor, 3, "0", STR_PAD_LEFT);
                }
                if ($campo == 'IT-NU-ND-SUBITEM') {
                    $listaempenho[$i]['subitem'] = str_pad($valor, 2, "0", STR_PAD_LEFT);
                }
                if ($campo == 'IT-QT-UNIDADE-ITEM') {
                    $listaempenho[$i]['quantidade'] = number_format($valor, 5, '.', '');
                }
                if ($campo == 'IT-VA-UNIDADE-ITEM') {
                    $listaempenho[$i]['valorunitario'] = number_format($valor, 2, '.', '');
                }
                if ($campo == 'IT-VA-TOTAL-ITEM') {
                    $listaempenho[$i]['valortotal'] = number_format($valor, 2, '.', '');
                }
                if ($campo == 'IT-TX-DESCRICAO-ITEM(1)') {
                    $listaempenho[$i]['descricao'] = strtoupper(utf8_encode($valor));
                }
            }

            $i++;
        }
        gzclose($myfile);

        if (copy($name . ".TXT.gz", $namedestino . ".LIDO.TXT.gz")) {
            unlink($name . ".TXT.gz");
        }
        return $listaempenho;
    }

    public function buscaEmpenhodetalhadoPorNumeroEmpenho($dado)
    {
        $ug = substr($dado, 0, 6);
        $gestao = substr($dado, 6, 5);
        $numempenho = strtoupper(substr($dado, 11, 12));
        $retorno = [];

        $empenho = Empenho::where('ug', $ug)
            ->where('gestao', $gestao)
            ->where('numero', $numempenho)
            ->first();

        if (count($empenho)) {

            $empenhodetalhado = $this->buscaEmpenhoDetalhadoPorUgGestaoLi($empenho);

            $i = 0;
            foreach ($empenhodetalhado as $det) {
                $retorno[$i]['numitem'] = $det->numitem;
                $retorno[$i]['subitem'] = $det->subitem;
                $retorno[$i]['quantidade'] = $det->quantidade;
                $retorno[$i]['valorunitario'] = $det->valorunitario;
                $retorno[$i]['valortotal'] = $det->valortotal;
                $i++;
            }

        }

        return json_encode($retorno);
    }

    public function buscaEmpenhoDetalhadoPorUgGestaoLi(Empenho $empenho)
    {
        $empenhodetalhado = Empenhodetalhado::where('ug', $empenho->ug)
            ->where('gestao', $empenho->gestao)
            ->where('numeroli', $empenho->num_lista)
            ->get();

        return $empenhodetalhado;
    }

}
