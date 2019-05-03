<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\_Siafi\SfpadraoController;
use App\Models\Sfpadrao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocHabilController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
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
            if(isset($arq1[1])){
                if ($arq1[1] == 'zip') {
                    $nomearquivo[] = $arq1[0];
                    $zip = new \ZipArchive();
                    if ($zip->open($path.$arq1[0].'.zip') === TRUE) {
                        $zip->extractTo($path.'/'.$arq1[0]);
                        $zip->close();
                    }
                }
                if ($arq1[1] == 'xml') {
                    $nomearquivo[] = $arq1[0];
                }
            }
        }

        if (count($nomearquivo)) {
            foreach ($nomearquivo as $nome) {
                if (substr($nome, 6, 3) == 'DDH') {
                    $dochabil = $this->lerArquivo($nome);
                    echo $nome . '<br>';
                }

            }

            $ok = 'Doc Habeis lidos.';

        } else {
            $ok = 'Não Há arquivos para leitura.';
        }

        return $ok;

    }


    public function lerArquivo(string $nomeaquivo)
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
            $i = null;
            try{
                foreach($xml->ns2CprDhConsultar as $key => $dochabil){
                    $i = $key;
                    $json = json_encode($dochabil);
                    $array = json_decode($json,TRUE);
                    $busca = new Sfpadrao;
                    $sfpadrao = $busca->createFromXml($array);
                }
            }catch (\Exception $exception){

//                echo "Erro Linha: ".$i;
                throw $exception;

//                die();

            }

        }

//        if(copy($name.".zip",$namedestino.".LIDO.zip")){
//            unlink($name);
//            unlink($name.".zip");
//        }


    }





}
