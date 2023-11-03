<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class MercadoPagoController extends Controller{
       
    
    public function pix(Request $request){
        $dados = $request->all(); 
        $dados["empresa_id"]  = session("usuario_pdv_logado")->empresa_uuid;
        $dados["origem"]        = "pdv";
        
        $url        = getenv("APP_URL_API"). "mercadopago/pix";
         echo $url;
         echo json_encode($dados);
         exit;
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        echo $resultado;
     }
    
     public function verificaPagamentoPix($id_venda){         
         $url        = getenv("APP_URL_API"). "mercadopago/verificaPagamentoPix/" . $id_venda;        
         $resultado  = enviarGetCurl($url);
         $retorno = new \stdClass();
         if(!isset($resultado->data->id)){
             $retorno->tem_erro = true;
         }else{
             $retorno->tem_erro = false;
             $retorno->retorno = $resultado;
         }
         return response()->json($retorno);
     }
    
}
