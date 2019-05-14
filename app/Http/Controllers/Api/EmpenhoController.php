<?php

namespace App\Http\Controllers\Api;

use App\Models\Credor;
use App\Models\Empenhodetalhado;
use App\Models\Obxne;
use App\Models\Ordembancaria;
use App\Models\Planointerno;
use App\Models\Unidade;
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

        foreach ($arquivos as $arq) {
            $arq1 = explode('.', $arq);
            if ($arq1[1] == 'TXT') {
                $nomearquivo[] = $arq1[0];
            }
        }

        if (count($nomearquivo)) {
            foreach ($nomearquivo as $nome) {
                if (substr($nome, 0, 2) == 'ne') {
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

        } else {
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
                if ($campo == 'GR-UG-GESTAO-AN-NUMERO-NEUQ(1)') {
                    $empenho[$i]['ug'] = substr($valor, 0, 6);
                    $empenho[$i]['gestao'] = substr($valor, 6, 5);
                    $empenho[$i]['numero'] = substr($valor, 11, 12);
                }
                if ($campo == 'GR-AN-NU-DOCUMENTO-REFERENCIA') {
                    $empenho[$i]['numero_ref'] = $valor;
                }
                if ($campo == 'IT-DA-EMISSAO') {
                    $empenho[$i]['emissao'] = substr($valor, 0, 4) . '-' . substr($valor, 4, 2) . '-' . substr($valor,
                            6, 2);
                }
                if ($campo == 'IT-IN-FAVORECIDO') {
                    $empenho[$i]['tipofavorecido'] = $valor;
                }
                if ($campo == 'IT-CO-FAVORECIDO') {
                    if ($empenho[$i]['tipofavorecido'] == 4) {
                        $empenho[$i]['favorecido'] = substr($valor, 0, 6);
                    } else {
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

        if (copy($name . ".TXT.gz", $namedestino . ".LIDO.TXT.gz")) {
            unlink($name . ".TXT.gz");
        }
        return $empenho;
    }

    public function buscaEmpenhoPorNumero($dado)
    {
        $ug = substr($dado, 0, 6);
        $gestao = substr($dado, 6, 5);
        $numempenho = strtoupper(substr($dado, 11, 12));
        $retorno = new \stdClass();

        $empenho = Empenho::where('ug', $ug)
            ->where('gestao', $gestao)
            ->where('numero', $numempenho)
            ->first();

        if (count($empenho)) {

            $credor = $this->buscaCredor($empenho->favorecido, $empenho->tipofavorecido);
            $planointerno = $this->buscaPlanointerno($empenho->planointerno);

            $retorno->ug = $empenho->ug;
            $retorno->gestao = $empenho->gestao;
            $retorno->numero = $empenho->numero;
            $retorno->emissao = $empenho->emissao;
            $retorno->tipocredor = $empenho->tipofavorecido;
            $retorno->cpfcnpjugidgener = $credor['codigo'];
            $retorno->nome = $credor['nome'];
            $retorno->observacao = $this->trataString($empenho->observacao);
            $retorno->fonte = $empenho->fonte;
            $retorno->naturezadespesa = $empenho->naturezadespesa;
            $retorno->picodigo = $planointerno['codigo'];
            $retorno->pidescricao = $planointerno['descricao'];

        }

        return json_encode($retorno);
    }

    public function buscaEmpenhoPorAnoUg($ano, $ug)
    {

        $retorno = [];

        $empenhos = Empenho::where('ug', $ug)
            ->where('numero', 'LIKE', $ano . 'NE%')
            ->get();

        if (count($empenhos)) {

            $i = 0;
            foreach ($empenhos as $empenho) {
                $credor = $this->buscaCredor($empenho->favorecido, $empenho->tipofavorecido);
                $planointerno = $this->buscaPlanointerno($empenho->planointerno);

                $empenhodetalhado = new EmpenhodetalhadoController;
                $uggestaoempenho = $empenho->ug.$empenho->gestao.$empenho->numero;

                $retorno[$i]['ug'] = $empenho->ug;
                $retorno[$i]['gestao'] = $empenho->gestao;
                $retorno[$i]['numero'] = $empenho->numero;
                $retorno[$i]['emissao'] = $empenho->emissao;
                $retorno[$i]['tipocredor'] = $empenho->tipofavorecido;
                $retorno[$i]['cpfcnpjugidgener']= $credor['codigo'];
                $retorno[$i]['nome'] = $credor['nome'];
                $retorno[$i]['observacao'] = $this->trataString($empenho->observacao);
                $retorno[$i]['fonte'] = $empenho->fonte;
                $retorno[$i]['naturezadespesa'] = $empenho->naturezadespesa;
                $retorno[$i]['picodigo'] = $planointerno['codigo'];
                $retorno[$i]['pidescricao'] = $planointerno['descricao'];
                $retorno[$i]['itens'] = $empenhodetalhado->buscaEmpenhodetalhadoPorNumeroEmpenho($uggestaoempenho);
                $i++;
            }
        }

        return json_encode($retorno);
    }


    public function buscaPlanointerno(string $pi)
    {
        $buscapi = Planointerno::where('codigo', $pi)
            ->first();

        if (!isset($buscapi->codigo)) {
            $planointerno['codigo'] = $pi;
            $planointerno['descricao'] = 'PLANO INTERNO NÃO CADASTRADO';

            return $planointerno;
        }

        $planointerno['codigo'] = $buscapi->codigo;
        $planointerno['descricao'] = $this->trataString($buscapi->descricao);

        return $planointerno;
    }

    public function buscaCredor(string $dado, string $tipo)
    {
        if ($tipo == '4') {
            $credor = $this->buscaCredorUnidade($dado);
        } else {
            $credor = $this->buscaCredorFavorecido($dado, $tipo);
        }

        return $credor;
    }

    public function buscaCredorUnidade(string $ug)
    {
        $unidade = Unidade::where('codigo', $ug)
            ->first();

        if (!isset($unidade->codigo)) {
            $credor['codigo'] = $ug;
            $credor['nome'] = 'CREDOR SEM CADASTRO';

            return $credor;
        }

        $credor['codigo'] = $unidade->codigo;
        $credor['nome'] = $this->trataString($unidade->nome);

        return $credor;
    }

    public function buscaCredorFavorecido(string $dado, string $tipo)
    {
        $dado = $this->formataCnpjCpfTipo($dado, $tipo);

        $favorecido = Credor::where('cpf_cnpj_idgener', $dado)
            ->first();

        if (!isset($favorecido->cpf_cnpj_idgener)) {
            $credor['codigo'] = $dado;
            $credor['nome'] = 'CREDOR SEM CADASTRO';

            return $credor;
        }

        $credor['codigo'] = $favorecido->cpf_cnpj_idgener;
        $credor['nome'] = $this->trataString($favorecido->nome);

        return $credor;
    }


}
