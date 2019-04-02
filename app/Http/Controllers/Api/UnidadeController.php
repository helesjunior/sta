<?php

namespace App\Http\Controllers\Api;

use App\Models\Unidade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnidadeController extends Controller
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
                if (substr($nome, 0, 2) == 'ug') {
                    $credor = $this->lerArquivo($nome);

                    foreach ($credor as $e) {
                        $busca = $this->buscaUnidade($e['codigo']);
                        if (!count($busca)) {
                            $novo_listaempenho = new Unidade;
                            $novo_listaempenho->codigo = $e['codigo'];
                            $novo_listaempenho->cnpj = $e['cnpj'];
                            $novo_listaempenho->funcao = $e['funcao'];
                            $novo_listaempenho->nome = $e['nome'];
                            $novo_listaempenho->uf = $e['uf'];
                            $novo_listaempenho->save();
                        }
                    }
                }

            }

            $ok = 'Unidades lidas.';
        } else {
            $ok = 'Não Há arquivos para leitura.';
        }

        return $ok;

    }

    protected function buscaUnidade($codigo)
    {

        $credor = Unidade::where('codigo', $codigo)
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
                if ($campo == 'IT-CO-UNIDADE-GESTORA') {
                    $credor[$i]['codigo'] = str_pad(substr($valor, 0, 6), 6, "0", STR_PAD_LEFT);
                }
                if ($campo == 'IT-NO-UNIDADE-GESTORA') {
                    $credor[$i]['nome'] = strtoupper(utf8_encode($valor));
                }
                if ($campo == 'IT-NU-CGC') {
                    $credor[$i]['cnpj'] = str_pad($valor, 14, "0", STR_PAD_LEFT);
                }
                if ($campo == 'IT-CO-UF') {
                    $credor[$i]['uf'] = strtoupper(utf8_encode($valor));
                }
                if ($campo == 'IT-IN-FUNCAO-UG') {
                    $credor[$i]['funcao'] = $valor;
                }
            }

            $i++;
        }

        gzclose($myfile);

        if (copy($name . ".TXT.gz", $namedestino . ".LIDO.TXT.gz")) {
            unlink($name . ".TXT.gz");
        }
        return $credor;
    }

}
