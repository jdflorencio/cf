<?php

namespace App\Modules\DanfeExpo\Repositories;

use Illuminate\Support\Facades\Storage;
use NFePHP\DA\NFe\{Danfe, Danfce};  
use NFePHP\DA\Legacy\FilesFolders;
// use App\Modules\DanfeExpo\Interfaces\DanfeStorageInterface;

class DanfeStorageRepository
{   
    /**
     * Realizar o Upload do XML
     * @param  array  $request 
     * @return array          
     */
    public function xml(array $request) 
    {
        $xmlSalvo = $request['file']->store('api/xml');
        $linkFileXML = Storage::url($xmlSalvo));

        $readXML = Storage::get($xmlSalvo);
        $xml = $this->xml2array(simplexml_load_string($readXML), array());

        if (array_key_exists("NFe", $xml)) {

            $chave = substr($xml["NFe"][0]["infNFeSupl"][1]["qrCode"], 55, 44);
             if ($xml["NFe"][0]["infNFe"][0]["ide"][0]["mod"] == 65) {

                $linkPDF = $this->danfeNFce($readXML, $chave);
             } else {
                $this->danfeNfe();
             }

        } else {
            dd('nota não autorizada!');
            $chave = substr($xml["infNFeSupl"][1]["qrCode"], 55, 44);

             if ($xml["infNFe"][0]["ide"][0]["mod"] == 65) {
                $danfe = $this->danfeNFce($readXML, $chave);

                return $danfe;
             } else {
                $this->danfeNfe();
             }
        }
    }

    /**
     * Gera o danfe baseado no XML NFc-e
     * @param  string $docxml 
     * @return [type]         
     */
    private function danfeNFce(string $docxml, string $filename)
    {
        $pathLogo =  __DIR__.'/images/logo.jpg';
        $danfce = new Danfce($docxml, $pathLogo, 0);        
        $id = $danfce->monta();
        $pdf = $danfce->render();

        Storage::put("api/pdf/{$filename}.pdf", $pdf);
        return Storage::url("api/pdf/{$filename}.pdf");
    }

    public function danfeNfe() : void
    {
        $docxml = Storage::get('55exemplo.xml');
        $logo = 'data://text/plain;base64,'. base64_encode(file_get_contents(__DIR__.'/images/logo.jpg'));
        try {
                $danfe = new Danfe($docxml, 'P', 'A4', $logo, 'I', '');
                $id = $danfe->montaDANFE();
                $pdf = $danfe->render();
                //o pdf porde ser exibido como view no browser
                //  //salvo em arquivo
                //      //ou setado para download forçado no browser 
                //          //ou ainda gravado na base de dados
                header('Content-disposition: inline; filename="nome_do_arquivo.pdf"');
                header('Content-Type: application/pdf');
                // header('Content-Disposition: attachment; filename="nota_fiscal.pdf"'); 

                // header('Content-Transfer-Encoding; binary');
                // header('Accept-Ranges; bytes');
                echo  $pdf;

            } catch (InvalidArgumentException $e) {
                echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
            }
    }

    public function nfce(Request $request)
    {   
        $file = $request->all();
        // dd($file['xml']);
        $file =substr($file['xml'], 21);
        $teste = base64_decode($file);
        $teste->store('xmls');

        // $teste =$teste->store('xmls');

        // $upload = Storage::put('1.xml', $file);
        // $upload = $request->xml->store('xmls');        
        $docxml = Storage::get($upload);
        $pathLogo =  __DIR__.'/images/logo.jpg';

        $danfce = new Danfce($docxml, $pathLogo, 0);
        
        $id = $danfce->monta();
        $pdf = $danfce->render();
        // header('Content-Type: application/pdf');     
        Storage::put('teste.pdf', $pdf);       
        $caminho = Storage::url('teste.pdf');
        // dd(url()->current());
        header("Location:/{$caminho}", true);


        // unlink(Storage::get('teste.pdf'));
        // dd()
    }

    public function teste() 
    {
        Storage::disk('local')->put('file.txt', 'Contents');
            return ["status" => "ok"];
    }
    
    public function upload(Request $request)
    {
        $this->visualizar();
    }

    public function visualizar()
    {
        // $file = dirname(PUBLIC_DIR) . DS . 'storage' . DS . 'app' . DS . $target . DS . $file;

        $file = Storage::get('teste.pdf');
        $path =  env('PUBLIC_DIR') . Storage::url('app/teste.pdf');

        // dd($path);

        if (file_exists($path)) {
            // dd('aqui');

            $mimetype = mime_content_type($path);
            header('Content-Type: ' . $mimetype);
            // header('Content-Transfer-Encoding: base64');
            $data = base64_encode(file_get_contents($path));
            header('Content-Length: ' . strlen($data));
            die(readfile($path));
        }

        echo 'Arquivo nao existe';
    }
    /**
     * Convert SimplesXML em um Array Bidmiensional
     * @param  string $source 
     * @param  array $arr    
     * @return array         
     */
    private function xml2array($source,$arr) : array
    {
        $xml = $source;
        $iter = 0;
            foreach($xml->children() as $b){
                    $a = $b->getName();
                    if(!$b->children()){
                            $arr[$a] = trim($b[0]);
                    }
                    else{
                            $arr[$a][$iter] = array();
                            $arr[$a][$iter] = $this->xml2array($b,$arr[$a][$iter]);
                    }
            $iter++;
            }
            return $arr;
    }
}
