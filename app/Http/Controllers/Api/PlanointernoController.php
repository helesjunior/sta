<?php

namespace App\Http\Controllers\Api;

use App\Models\Planointerno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanointernoController extends Controller
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
                if (substr($nome, 0, 2) == 'pi') {
                    $planointerno = $this->lerArquivo($nome);

                    foreach ($planointerno as $e) {
                        $busca = $this->buscaPi($e['codigo']);
                        if (!count($busca)) {
                            $novo_listaempenho = new Planointerno;
                            $novo_listaempenho->codigo = $e['codigo'];
                            $novo_listaempenho->descricao = $e['descricao'];
                            $novo_listaempenho->save();
                        }
                    }
                }

            }

            $ok = 'Planos Internos Lidos.';
        } else {
            $ok = 'Não Há arquivos para leitura.';
        }

        return $ok;

    }

    protected function buscaPi($codigo)
    {

        $planointerno = Planointerno::where('codigo', $codigo)
            ->get();

        return $planointerno;

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
                if ($campo == 'IT-CO-PLANO-INTERNO') {
                    $planointerno[$i]['codigo'] = strtoupper(utf8_encode($valor));
                }
                if ($campo == 'IT-NO-PLANO-INTERNO') {
                    $planointerno[$i]['descricao'] = strtoupper(utf8_encode($valor));
                }
            }

            $i++;
        }
        gzclose($myfile);

        if (copy($name . ".TXT.gz", $namedestino . ".LIDO.TXT.gz")) {
            unlink($name . ".TXT.gz");
        }
        return $planointerno;
    }

}
