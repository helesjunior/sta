<?php

namespace App\Http\Controllers\Api;

use App\Models\Obxne;
use App\Models\Ordembancaria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdembancariaController extends Controller
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
                if (substr($nome, 0, 2) == 'ob' or substr($nome, 6, 2) == 'ob') {
                    $ordembancaria = $this->lerArquivo($nome);

                    foreach ($ordembancaria as $e) {
                        $busca = $this->buscaOrdembancaria($e['ug'], $e['gestao'], $e['numero']);
                        if (!count($busca)) {
                            $novo_ordembancaria = new Ordembancaria;
                            $novo_ordembancaria->ug = $e['ug'];
                            $novo_ordembancaria->gestao = $e['gestao'];
                            $novo_ordembancaria->numero = $e['numero'];
                            $novo_ordembancaria->emissao = $e['emissao'];
                            $novo_ordembancaria->tipofavorecido = $e['tipofavorecido'];
                            $novo_ordembancaria->favorecido = $e['favorecido'];
                            $novo_ordembancaria->bancodestino = $e['bancodestino'];
                            $novo_ordembancaria->agenciadestino = $e['agenciadestino'];
                            $novo_ordembancaria->contadestino = $e['contadestino'];
                            $novo_ordembancaria->processo = $e['processo'];
                            $novo_ordembancaria->tipoob = $e['tipoob'];
                            $novo_ordembancaria->observacao = $e['observacao'];
                            $novo_ordembancaria->cancelamentoob = $e['cancelamentoob'];
                            $novo_ordembancaria->numeroobcancelamento = $e['numeroobcancelamento'];
                            $novo_ordembancaria->valor = $e['valor'];
                            $novo_ordembancaria->documentoorigem = $e['documentoorigem'];
                            $novo_ordembancaria->save();

                            if (isset($e['empenhos'])) {
                                foreach ($e['empenhos'] as $emp) {
                                    $obxne = new Obxne;
                                    $obxne->ordembancaria_id = $novo_ordembancaria->id;
                                    $obxne->numeroempenho = $novo_ordembancaria->ug . $novo_ordembancaria->gestao . $emp;
                                    $obxne->save();
                                }
                            }
                        }
                    }
                }

            }

            $ok = 'Ordens bancarias lidos.';

        } else {
            $ok = 'Não Há arquivos para leitura.';
        }

        return $ok;

    }

    protected function buscaOrdembancaria($ug, $gestao, $numero)
    {

        $ordembancaria = Ordembancaria::where('ug', $ug)
            ->where('gestao', $gestao)
            ->where('numero', $numero)
            ->get();

        return $ordembancaria;

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
                if ($campo == 'GR-UG-GESTAO-AN-NUMERO-OBUQ') {
                    $ordembancaria[$i]['ug'] = substr($valor, 0, 6);
                    $ordembancaria[$i]['gestao'] = substr($valor, 6, 5);
                    $ordembancaria[$i]['numero'] = substr($valor, 11, 12);
                }
                if ($campo == 'IT-DA-EMISSAO') {
                    $ordembancaria[$i]['emissao'] = substr($valor, 0, 4) . '-' . substr($valor, 4,
                            2) . '-' . substr($valor, 6, 2);
                }
                if ($campo == 'IT-IN-FAVORECIDO') {
                    $ordembancaria[$i]['tipofavorecido'] = $valor;
                }
                if ($campo == 'IT-CO-FAVORECIDO') {
                    if ($ordembancaria[$i]['tipofavorecido'] == 4) {
                        $ordembancaria[$i]['favorecido'] = trim(substr($valor, 0, 6));
                    } else {
                        $ordembancaria[$i]['favorecido'] = trim($valor);
                    }
                }

                if ($campo == 'IT-CO-BANCO-DESTINO') {
                    $ordembancaria[$i]['bancodestino'] = str_pad($valor, 3, "0", STR_PAD_LEFT);
                }

                if ($campo == 'IT-CO-AGENCIA-DESTINO') {
                    $ordembancaria[$i]['agenciadestino'] = $valor;
                }

                if ($campo == 'IT-NU-CONTA-CORRENTE-DESTINO') {
                    $ordembancaria[$i]['contadestino'] = $valor;
                }

                if ($campo == 'IT-NU-PROCESSO') {
                    $ordembancaria[$i]['processo'] = $valor;
                }

                if ($campo == 'IT-IN-TIPO-OB') {
                    $ordembancaria[$i]['tipoob'] = $valor;
                }

                for ($n = 1; $n <= 20; $n++) {
                    if ($campo == strval('IT-TX-OBSERVACAO-DOCUMENTO(' . $n . ')')) {
                        if (isset($ordembancaria[$i]['observacao'])) {
                            $ordembancaria[$i]['observacao'] .= trim(strtoupper(utf8_encode($valor)));
                        } else {
                            $ordembancaria[$i]['observacao'] = trim(strtoupper(utf8_encode($valor)));
                        }
                    }
                }

                if ($campo == 'IT-TX-OBSERVACAO') {
                    $ordembancaria[$i]['observacao'] = trim(strtoupper(utf8_encode($valor)));
                }

                if ($campo == 'IT-IN-CANCELAMENTO-OB') {
                    $ordembancaria[$i]['cancelamentoob'] = $valor;
                }

                if ($campo == 'GR-AN-NU-OB-CANCELAMENTO') {
                    $ordembancaria[$i]['numeroobcancelamento'] = $valor;
                }

                if ($campo == 'GR-AN-NU-DOCUMENTO-REFERENCIA') {
                    $ordembancaria[$i]['documentoorigem'] = $valor;
                }

                if ($campo == 'IT-VA-EVENTO-SISTEMA') {
                    $ordembancaria[$i]['valor'] = number_format($valor, 2, '.', '');
                }

                for ($n = 1; $n <= 100; $n++) {
                    if ($campo === 'IT-CO-INSCRICAO01(' . $n . ')') {
                        if (strstr($valor, 'NE')) {
                            $ordembancaria[$i]['empenhos'][$n] = substr(strtoupper(utf8_encode($valor)), 0, 12);
                        }

                    }

                    if ($campo === 'IT-CO-INSCRICAO1(' . $n . ')') {
                        if (strstr($valor, 'NE')) {
                            $ordembancaria[$i]['empenhos'][$n] = substr(strtoupper(utf8_encode($valor)), 0, 12);
                        }
                    }
                }
            }

            if (isset($ordembancaria[$i]['empenhos'])) {
                $ordembancaria[$i]['empenhos'] = array_unique($ordembancaria[$i]['empenhos']);
            }
            $i++;
        }
        gzclose($myfile);

        if (copy($name . ".TXT.gz", $namedestino . ".LIDO.TXT.gz")) {
            unlink($name . ".TXT.gz");
        }
        return $ordembancaria;
    }

    public function buscaOrdembancariaPorCnpj($dado)
    {

        $retorno = [];

        $ordembancaria = Ordembancaria::where('favorecido', trim($dado))
            ->orderBy('emissao')
            ->get();


        if (count($ordembancaria)) {

            $i = 0;
            foreach ($ordembancaria as $ob) {
                $onxne = Obxne::where('ordembancaria_id', $ob->id)
                    ->orderBy('id')
                    ->pluck('numeroempenho')->toArray();;

                $credor = new EmpenhoController();
                $favorecido = $credor->buscaCredor($ob->favorecido, $ob->tipofavorecido);

                $retorno[$i]['ug'] = $ob->ug;
                $retorno[$i]['gestao'] = $ob->gestao;
                $retorno[$i]['numero'] = $ob->numero;
                $retorno[$i]['emissao'] = $ob->emissao;
                $retorno[$i]['tipofavorecido'] = $ob->tipofavorecido;
                $retorno[$i]['favorecidocodigo'] = $favorecido['codigo'];
                $retorno[$i]['favorecidonome'] = $favorecido['nome'];
                $retorno[$i]['observacao'] = $this->trataString($ob->observacao);
                $retorno[$i]['tipoob'] = $ob->tipoob;
                $retorno[$i]['processo'] = $ob->processo;
                $retorno[$i]['cancelamentoob'] = $ob->cancelamentoob;
                $retorno[$i]['numeroobcancelamento'] = $ob->numeroobcancelamento;
                $retorno[$i]['valor'] = number_format($ob->valor, 2, ',', '.');
                $retorno[$i]['documentoorigem'] = $ob->documentoorigem;
                $retorno[$i]['empenhos'] = $onxne;

                $i++;
            }

        }

        return json_encode($retorno);

    }

    public function buscaOrdembancariaPorAnoUg($ano, $ug)
    {

        $retorno = [];

        $ordembancaria = Ordembancaria::where('numero', 'LIKE', trim($ano) . 'OB%')
            ->where('ug', $ug)
            ->orderBy('emissao')
            ->get();

        if (count($ordembancaria)) {

            $i = 0;
            foreach ($ordembancaria as $ob) {
                $onxne = Obxne::where('ordembancaria_id', $ob->id)
                    ->orderBy('id')
                    ->pluck('numeroempenho')->toArray();;

                $credor = new EmpenhoController();
                $favorecido = $credor->buscaCredor($ob->favorecido, $ob->tipofavorecido);

                $retorno[$i]['ug'] = $ob->ug;
                $retorno[$i]['gestao'] = $ob->gestao;
                $retorno[$i]['numero'] = $ob->numero;
                $retorno[$i]['emissao'] = $ob->emissao;
                $retorno[$i]['tipofavorecido'] = $ob->tipofavorecido;
                $retorno[$i]['favorecidocodigo'] = $favorecido['codigo'];
                $retorno[$i]['favorecidonome'] = $favorecido['nome'];
                $retorno[$i]['observacao'] = $this->trataString($ob->observacao);
                $retorno[$i]['tipoob'] = $ob->tipoob;
                $retorno[$i]['processo'] = $ob->processo;
                $retorno[$i]['cancelamentoob'] = $ob->cancelamentoob;
                $retorno[$i]['numeroobcancelamento'] = $ob->numeroobcancelamento;
                $retorno[$i]['valor'] = number_format($ob->valor, 2, ',', '.');
                $retorno[$i]['documentoorigem'] = $ob->documentoorigem;
                $retorno[$i]['empenhos'] = $onxne;

                $i++;
            }

        }

        return json_encode($retorno);

    }


}
