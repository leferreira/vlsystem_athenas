<?php
namespace App\Http\Controllers\Admin\Nfe;

use App\Http\Controllers\Controller;
use App\Models\CertificadoDigital;
use App\Models\Emitente;
use App\Models\Nfe;
use App\Service\NotaFiscalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service\VendaService;
use App\Models\NfeDuplicata;
use App\Service\MovimentoService;
use App\Service\ContaReceberSevice;
use App\Service\ContaPagarSevice;

class NfeController extends Controller{ 
    public static function verXMLNormal($id_nfe){
        $url         = getenv("APP_URL_API"). "nfe/lerXml/" . $id_nfe;        
        $resultado   = enviarGetCurlSDecode($url);
        
        $nfe            = Nfe::find($id_nfe);
        $pastaAmbiente  = ($nfe->tpAmb == "1") ? "producao" : "homologacao";
        $caminho        =  url("storage/". $nfe->empresa->pasta."/xml/nfe/".$pastaAmbiente."/temporarias/".$nfe->chave."-nfe.xml") ;
        $url            = str_replace("/erp/", "/api/", $caminho);    
      
        return redirect($url);  
    }
    
    public function transmitir($id_nfe){
        $nfe        = Nfe::find($id_nfe);
        $emitente   = Emitente::where("empresa_id",Auth::user()->empresa_id)->first();
        $certificado= CertificadoDigital::where("emitente_id", $emitente->id)->first();        
               
        if(!$certificado->certificado_senha){
            return redirect()->back()->with('msg_erro', "Configure a senha do certificado primeiramente.");
        }
        
        
        
        $notafiscal = NotaFiscalService::transferir($nfe);      
        $url        = getenv("APP_URL_API"). "nfe/transmitir";   
        
        $resultado  = enviarPostJsonCurl($url,json_encode($notafiscal->notafiscal)); 
        
        //Verificar o tipo nota
        echo $resultado;
    }
    
    public function transmitirNfePelaVendaJs($id_venda){
        $nfe        = Nfe::where("venda_id", $id_venda)->first();       
   
        $emitente   = Emitente::where("empresa_id",Auth::user()->empresa_id)->first();
        $certificado= CertificadoDigital::where("emitente_id", $emitente->id)->first();
        $retorno    = new \stdClass();
        
        if(!$emitente->ultimo_numero_nfe){
            $retorno->tem_erro = true;
            $retorno->erro = "Configure o número do Último NFE";
            return response()->json($retorno);
        }
        
        if(!$emitente->numero_serie_nfe){
            $retorno->tem_erro = true;
            $retorno->erro = "Configure o número do Série Padrão.";
            return response()->json($retorno);
        }
        
        if(!$certificado->certificado_senha){
            $retorno->tem_erro = true;
            $retorno->erro = "Configure o  certificado digital primeiramente.";
            return response()->json($retorno);
        }
        
        if(!$certificado->certificado_senha){
            $retorno->tem_erro = true;
            $retorno->erro = "Configure a senha do certificado primeiramente.";
            echo json_encode($retorno);
            exit;
        }
        
        $url         = getenv("APP_URL_API"). "nfe/transmitirPelaNfe/".$nfe->id;
        
        $resultado   = enviarGetCurlSDecode($url);
        //echo json_encode($resultado);
        echo $resultado;
      
    }
    
    public function transmitirJs(Request $request,$id_nfe){
    
        $emitente   = Emitente::where("empresa_id",Auth::user()->empresa_id)->first();
        $certificado= CertificadoDigital::where("empresa_id", Auth::user()->empresa_id)->first();
        $retorno    = new \stdClass();
   
        if(!$certificado){
            $retorno->tem_erro = true;
            $retorno->erro = "Configure a senha do certificado primeiramente.";
            echo json_encode($retorno);
            exit;
        }
        
        if(!$emitente->ultimo_numero_nfe){
            $retorno->tem_erro = true;
            $retorno->erro = "Configure o número do Último NFE";
            return response()->json($retorno);
        }
        
        if(!$emitente->numero_serie_nfe){
            $retorno->tem_erro = true;
            $retorno->erro = "Configure o número do Série Padrão.";
            return response()->json($retorno);
        }
        
        if(!$certificado->certificado_senha){
            $retorno->tem_erro = true;
            $retorno->erro = "Configure o  certificado digital primeiramente.";
            return response()->json($retorno);
        }
        
        $nfe = Nfe::find($id_nfe);
        if($nfe->status_id==config("constantes.status.AUTORIZADO")){
            $retorno->tem_erro = true;
            $retorno->erro = "Esta nota já foi autorizada, você não pode mais transmiti-la.";
            return response()->json($retorno);            
        }
        
        if($nfe->status_id==config("constantes.status.CANCELADO")){
            $retorno->tem_erro = true;
            $retorno->erro = "Esta nota já foi CANCELADA, você não pode mais transmiti-la.";
            return response()->json($retorno);
        }
        $nfe->controla_estoque      =  $request->gerar_estoque ?? "N";
        $nfe->controla_financeiro   =  $request->gerar_financeiro ?? "N";
        $nfe->save();
        
        $url                = getenv("APP_URL_API"). "nfe/transmitirPelaNfe/".$id_nfe;
        $resultado          = enviarGetCurlSDecode($url);
        $retorno            = json_decode($resultado);
        $protocolo          = $retorno->protocolo ?? null;
        if($protocolo){
            if($retorno->status_id==config("constantes.status.AUTORIZADO")){
                if($nfe->controla_estoque=="S"){
                    $tipo_movimento = config("constantes.tipo_movimento.SAIDA_NFE");
                    $descricao = "Saida NFE : #" . $id_nfe;
                    MovimentoService::lancarEstoqueDaNfe($id_nfe, $tipo_movimento, $descricao);
                }
                if($nfe->controla_financeiro=="S"){
                    if($nfe->tpNF==1){
                        ContaReceberSevice::salvarContaReceberPelaNfe($nfe);
                    }else{
                        ContaPagarSevice::salvarContaPagarPelaNfe($nfe);
                    }
                    
                }
            }
        }
        echo $resultado;
    }
    
    
    public function imprimirDanfePelaChave($chave){
        $url         = getenv("APP_URL_API"). "nfe/imprimirDanfePelaChave/" . $chave;
        echo $url;
        exit;
        $resultado   = enviarGetCurlSDecode($url);
        header("Content-type: application/pdf");
        i($resultado);
    }
    
    public function imprimirDanfePelaNfe($id_nfe){
        $url         = getenv("APP_URL_API"). "nfe/imprimirDanfePelaNfe/" . $id_nfe;
        $resultado   = enviarGetCurlSDecode($url);
        header("Content-type: application/pdf");
        i($resultado);
    }
    
    public function simularDanfe($id_nfe){
        $url         = getenv("APP_URL_API"). "nfe/simularDanfe/" . $id_nfe;
        $resultado   = enviarGetCurlSDecode($url);
        $retorno     = json_decode($resultado);      
        if(isset($retorno->tem_erro)){
            i($retorno->erro);
        }      
        header("Content-type: application/pdf");
        i($resultado);
    }
    
    public function imprimirDanfePelaVenda($id_venda){
        $url         = getenv("APP_URL_API"). "nfe/imprimirDanfePelaVenda/" . $id_venda;
        $resultado   = enviarGetCurlSDecode($url);
        header("Content-type: application/pdf");
        i($resultado);
    }
    
    public function danfe($id_nfe){
        $nfe         = Nfe::find($id_nfe);
        $url         = getenv("APP_URL_API"). "nfe/danfe/" . $nfe->chave;
        $resultado   = enviarGetCurlSDecode($url);
        header("Content-type: application/pdf");
        echo $resultado;
    }
    
    public function imprimirCce($id_nfe){     
        $url         = getenv("APP_URL_API"). "nfe/imprimirCce/" . $id_nfe;
        $resultado   = enviarGetCurlSDecode($url);
        header("Content-type: application/pdf");
        i($resultado);
    }
    
    public function imprimircancelado($id_nfe){
        $url         = getenv("APP_URL_API"). "nfe/imprimircancelado/" . $id_nfe;
        $resultado   = enviarGetCurlSDecode($url);
        header("Content-type: application/pdf");
        i($resultado);
    }
    public function cartaCorrecao(Request $request){
        $req         = $request->all();
        $valores     = new \stdClass();
        $valores->id = $req["id"];
        $valores->correcao = $req["correcao"];        
        
        $url         = getenv("APP_URL_API"). "nfe/cartaCorrecao";
        $resultado   = enviarPostJsonCurl($url,json_encode($valores));
        echo $resultado;
    }
    
    public function inutilizarNfe(Request $request){
        $req         = $request->all();
        $emitente    = Emitente::where("empresa_id", auth()->user()->empresa_id)->first();
        $valores     = new \stdClass();
        $valores->justificativa = $req["justificativa"];
        $valores->nSerie        = $req["nSerie"];
        $valores->nIni          = $req["nIni"];
        $valores->nFin          = $req["nFin"];
        $valores->cnpj          = $emitente->cnpj; 
        $valores->tpAmb         = $emitente->ambiente_nfe;
        $url         = getenv("APP_URL_API"). "nfe/inutilizarNfe";
        $resultado   = enviarPostJsonCurl($url,json_encode($valores));
        echo $resultado;
    }
    
    public function cancelarNfe(Request $request){
        $req                    = $request->all();
        $valores                = new \stdClass();
        $valores->id            = $req["id"];
        $valores->justificativa = $req["justificativa"];        
        $url                    = getenv("APP_URL_API"). "nfe/cancelarNfe";
        $resultado              = enviarPostJsonCurl($url,json_encode($valores));       
        $retorno                = json_decode($resultado);        
        if(($retorno->tem_erro ?? null) == false){
            $nfe = Nfe::find($valores->id);
            if(($nfe->venda_id ?? null) != null){
                VendaService::cancelarVenda($nfe->venda_id);
            }
        }        
        return response()->json($retorno);
    }
    
    
    
    public function consultarNfe($id_nfe){
        $url         = getenv("APP_URL_API"). "nfe/consultarNfe/" . $id_nfe;
        $resultado   = enviarGetCurlSDecode($url);       
        i($resultado);
    }
    
    public function baixarXML($id_nfe){
        $nfe         = Nfe::find($id_nfe);
        $url         = getenv("APP_URL_API"). "nfe/baixarXml/" . $nfe->chave;
        $resultado   = enviarGetCurlSDecode($url);
        //header("Content-type: text/xml; charset=UTF-8");
        file_put_contents($nfe->chave.'.xml', $resultado);
        
        //CRIA O ZIP
        $zip = new \ZipArchive();
        $arquivoZip = $nfe->chave .".zip";
        
        if ($zip->open($arquivoZip, \ZipArchive::CREATE)!==TRUE) {
            exit("Erro ao criar <$arquivoZip>\n");
        }
        $zip->addFile($nfe->chave.'.xml');
        $zip->close();
        //APAGA OS ARQUIVOS        
        if (file_exists($arquivoZip)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($arquivoZip) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($arquivoZip));
            readfile($arquivoZip);
            exit;
        }
        //echo $resultado;
    }
    
    public function baixarPdf($id_nfe){
        $nfe         = Nfe::find($id_nfe);
        $url         = getenv("APP_URL_API"). "nfe/baixarPdf/" . $nfe->chave;
        $resultado   = enviarGetCurlSDecode($url);        
        file_put_contents($nfe->chave.'.pdf', $resultado);
        
        //CRIA O ZIP
        $zip = new \ZipArchive();
        $arquivoZip = "pdf_".$nfe->chave .".zip";
        
        if ($zip->open($arquivoZip, \ZipArchive::CREATE)!==TRUE) {
            exit("Erro ao criar <$arquivoZip>\n");
        }
        $zip->addFile($nfe->chave.'.pdf');
        $zip->close();
        //APAGA OS ARQUIVOS
        if (file_exists($arquivoZip)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($arquivoZip) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($arquivoZip));
            readfile($arquivoZip);
            exit;
        }
    }
    
   
   public function email(Request $request){
       $objeto              = new \stdClass();
       $objeto->id_nfe      = $request->id_nfe;
       $objeto->email       = $request->email;  
       
       $url = getenv("APP_URL_API"). "nfe/email";
       $resultado =  enviarPostJsonCurl($url,json_encode($objeto));
       echo $resultado;
   }
   
   
   
   public function verXML($id_nfe){
       $nfe         = Nfe::find($id_nfe);
       $url         = getenv("APP_URL_API"). "nfe/transmitir/xml/" . $nfe->chave;
       $resultado   = enviarGetCurlSDecode($url);
       header("Content-type: text/xml; charset=UTF-8");
       echo $resultado;
   }
   
}
