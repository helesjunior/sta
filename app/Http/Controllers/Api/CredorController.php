<?php

namespace App\Http\Controllers\Api;

use App\Models\Credor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CredorController extends Controller
{
    public function index()
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
                if (substr($nome, 0, 6) == 'credor') {
                    $credor = $this->lerArquivo($nome);

                    foreach ($credor as $e) {
                        $busca = $this->buscaCredor($e['cpf_cnpj_idgener']);
                        if (!count($busca)) {
                            $novo_listaempenho = new Credor;
                            $novo_listaempenho->cpf_cnpj_idgener = $e['cpf_cnpj_idgener'];
                            $novo_listaempenho->tipofornecedor = $e['tipo_fornecedor'];
                            $novo_listaempenho->nome = $e['nome'];
                            $novo_listaempenho->uf = $e['uf'];
                            $novo_listaempenho->save();
                        }
                    }
                }

            }

            $ok = 'Credores lidos.';
        } else {
            $ok = 'Não Há arquivos para leitura.';
        }

        return $ok;

    }

    protected function buscaCredor($cnpjcpfidgener)
    {

        $credor = Credor::where('cpf_cnpj_idgener', $cnpjcpfidgener)
            ->get();

        return $credor;

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
                if ($campo == 'IT-CO-CREDOR') {
                    $credor[$i]['dado'] = $valor;
                }
                if ($campo == 'IT-CO-TIPO-CREDOR') {
                    $credor[$i]['tipo_fornecedor'] = $valor;
                }
                if ($campo == 'IT-NO-CREDOR') {
                    $credor[$i]['nome'] = strtoupper(utf8_encode($valor));
                }
                if ($campo == 'IT-CO-UF-CREDOR') {
                    $credor[$i]['uf'] = strtoupper(utf8_encode($valor));
                }
            }

            if ($credor[$i]['tipo_fornecedor'] == 4) {
                $credor[$i]['cpf_cnpj_idgener'] = str_pad(substr($credor[$i]['dado'], 0, 6), 6, "0", STR_PAD_LEFT);
            } else {
                $credor[$i]['cpf_cnpj_idgener'] = $this->formataCnpjCpf($credor[$i]['dado'], $credor[$i]['tipo_fornecedor']);
            }

            $i++;
        }
        gzclose($myfile);

        if (copy($name . ".TXT.gz", $namedestino . ".LIDO.TXT.gz")) {
            unlink($name . ".TXT.gz");
        }
        return $credor;
    }

    public function formataCnpjCpf($dado, $tipo)
    {

        $retorno = $dado;

        if ($tipo == '1') {
            $d[0] = substr($dado, 0, 2);
            $d[1] = substr($dado, 2, 3);
            $d[2] = substr($dado, 5, 3);
            $d[3] = substr($dado, 8, 4);
            $d[4] = substr($dado, 12, 2);

            $retorno = $d[0] . '.' . $d[1] . '.' . $d[2] . '/' . $d[3] . '-' . $d[4];

        }

        if ($tipo == '2') {
            $d[0] = substr($dado, 0, 3);
            $d[1] = substr($dado, 3, 3);
            $d[2] = substr($dado, 6, 3);
            $d[3] = substr($dado, 9, 2);

            $retorno = $d[0] . '.' . $d[1] . '.' . $d[2] . '-' . $d[3];
        }

        return $retorno;

    }

}
