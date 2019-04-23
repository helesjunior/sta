<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Siafi\SfpadraoController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocHabilController extends Controller
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
            if ($arq1[1] == 'zip') {
                $nomearquivo[] = $arq1[0];
                $zip = new \ZipArchive();
                if ($zip->open($path.$arq1[0].'.zip') === TRUE) {
                    $zip->extractTo($path.'/'.$arq1[0]);
                    $zip->close();
                } else {
                }
            }
            if ($arq1[1] == 'xml') {
                $nomearquivo[] = $arq1[0];
            }

        }

        if (count($nomearquivo)) {
            foreach ($nomearquivo as $nome) {
                if (substr($nome, 6, 4) == 'DDHD') {
                    $dochabil = $this->lerArquivo($nome);
                }

            }

            $ok = 'Doc Habeis lidos.';

        } else {
            $ok = 'Não Há arquivos para leitura.';
        }

        return $ok;

    }


    public function lerArquivo($nomeaquivo)
    {
        $path = config('app.path_pendentes');
        $path_processados = config('app.path_processados');
        $name = $path . $nomeaquivo;
        $namedestino = $path_processados . $nomeaquivo;

        if(is_file($name.".xml")){
            $myfile = file_get_contents($name.".xml");
        }else{
            $myfile = file_get_contents($name."/".$nomeaquivo.".xml");
        }

        $xml = simplexml_load_string(str_replace(':','',$myfile));

        if(isset($xml->ns2CprDhConsultar))
        {
            foreach($xml->ns2CprDhConsultar as $dochabil){

                $busca = new SfpadraoController;

                $registro = $busca->buscaSfpadrao($dochabil);

                if(!count($registro)){

                    $sfpadrao = $busca->inserirSfpadrao($dochabil);

                }else{

//                    $sfpadrao = $busca->atualizaSfpadrao($dochabil);

                }
                echo $dochabil->codUgEmit.''.$dochabil->anoDH.''.$dochabil->codTipoDH.''.$dochabil->numDH.'<br>';
            }
        }

    }
}
