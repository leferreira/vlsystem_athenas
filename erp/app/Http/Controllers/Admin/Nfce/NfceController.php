<?php
namespace App\Http\Controllers\Admin\Nfce;

use App\Http\Controllers\Controller;
use App\Models\Nfce;
use Illuminate\Http\Request;

class NfceController extends Controller{  
    
    public function transmitirPelaNfce($id_nfce){   
        $url        = getenv("APP_URL_API"). "pdv/transmitirPelaNfce/" . $id_nfce;
        i($url);
        $resultado  = enviarGetCurlSDecode($url);
        i($resultado);
        echo $resultado;
    }
   
    public function transmitirJs(Request $request,$id_nfce){        
        $retorno    = new \stdClass();    
        
        $nfce = Nfce::find($id_nfce);
        if($nfce->status_id==config("constantes.status.AUTORIZADO")){
            $retorno->tem_erro = true;
            $retorno->erro = "Esta nota já foi autorizada, você não pode mais transmiti-la.";
            return response()->json($retorno);
        }
        
        if($nfce->status_id==config("constantes.status.CANCELADO")){
            $retorno->tem_erro = true;
            $retorno->erro = "Esta nota já foi CANCELADA, você não pode mais transmiti-la.";
            return response()->json($retorno);
        }
        if($nfce->status_id==config("constantes.status.DENEGADO")){
            $retorno->tem_erro = true;
            $retorno->erro = "Esta nota já foi DENEGADA, você não pode mais transmiti-la.";
            return response()->json($retorno);
        }
        
        $url                = getenv("APP_URL_API"). "pdv/transmitirPelaNfce/" . $id_nfce;
        $resultado          = enviarGetCurlSDecode($url);
      
        echo $resultado;
    }
    
    public function danfce($id_nfce){
        $nfce         = nfce::find($id_nfce);
        $url         = getenv("APP_URL_API"). "nfce/danfce/" . $nfce->chave;       
        $resultado   = enviarGetCurlSDecode($url);
        header("Content-type: application/pdf");
        i($resultado);
    }
    
    
    public function imprimirDanfcePelaVenda($id){
        $nfce            = Nfce::where("venda_id",$id)->first();
        
        $url         = getenv("APP_URL_API"). "nfce/danfce/" . $nfce->chave;
        $resultado   = enviarGetCurlSDecode($url);
        header("Content-type: application/pdf");
        i($resultado);
    }
    
    
    
    public function baixarXML($id_nfce){
        $nfce         = nfce::find($id_nfce);
        $url         = getenv("APP_URL_API"). "nfce/baixarXml/" . $nfce->chave;       
        $resultado   = enviarGetCurlSDecode($url);
        //header("Content-type: text/xml; charset=UTF-8");
        file_put_contents($nfce->chave.'.xml', $resultado);
        
        //CRIA O ZIP
        $zip = new \ZipArchive();
        $arquivoZip = $nfce->chave .".zip";
        
        if ($zip->open($arquivoZip, \ZipArchive::CREATE)!==TRUE) {
            exit("Erro ao criar <$arquivoZip>\n");
        }
        $zip->addFile($nfce->chave.'.xml');
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
    
    public function baixarPdf($id_nfce){
        $nfce         = nfce::find($id_nfce);
        $url         = getenv("APP_URL_API"). "nfce/baixarPdf/" . $nfce->chave;
        $resultado   = enviarGetCurlSDecode($url);        
        file_put_contents($nfce->chave.'.pdf', $resultado);
        
        //CRIA O ZIP
        $zip = new \ZipArchive();
        $arquivoZip = "pdf_".$nfce->chave .".zip";
        
        if ($zip->open($arquivoZip, \ZipArchive::CREATE)!==TRUE) {
            exit("Erro ao criar <$arquivoZip>\n");
        }
        $zip->addFile($nfce->chave.'.pdf');
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
       $objeto->id_nfce      = $request->id_nfce;
       $objeto->email       = $request->email;  
       
       $url = getenv("APP_URL_API"). "nfce/email";
       $resultado =  enviarPostJsonCurl($url,json_encode($objeto));
       echo $resultado;
   }
   
   
   
   public function verXML($id_nfce){
       $nfce         = nfce::find($id_nfce);
       $url         = getenv("APP_URL_API"). "nfce/transmitir/xml/" . $nfce->chave;
       $resultado   = enviarGetCurlSDecode($url);
       header("Content-type: text/xml; charset=UTF-8");
       echo $resultado;
   }
   
}
