<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MercadoPagoController extends Controller{
    
    
    public function pix(Request $request){
        try {
            $dados                  = $request->all();
            $dados["origem"]        = "cobranca";            
            $url                    = getenv("APP_URL_API"). "mercadopago/pix";
          /*/* echo $url;
             echo json_encode($dados);
             exit;**/
            $resultado              = enviarPostJsonCurl($url,json_encode($dados));
            echo  $resultado;
        } catch (\Exception $e) {
            $mensagem = $e->getMessage();
            return redirect()->route('erro')->with('msg_erro', $mensagem);
        }
        
     }
    
     public function cartao(Request $request){
         try {
             $dados                  = $request->all();
             $dados["origem"]        = "cobranca";
             
             $url                    = getenv("APP_URL_API"). "mercadopago/cartao";
           /*  echo $url;
             echo json_encode($dados);
             exit;*/
             $resultado              = enviarPostJsonCurl($url,json_encode($dados));
			 echo $resultado;            
         } catch (\Exception $e) {
             $resultado = new \stdClass();
             $resultado->tem_erro = true;
             $resultado->erro = $e->getMessage();
             return response()->json($e->getMessage());
         }
         
     }
     
     
     public function boleto(Request $request){
         try {
             $dados                  = $request->all();
             $dados["origem"]        = "cobranca";             
             $url                    = getenv("APP_URL_API"). "mercadopago/boleto";  
             $resultado              = enviarPostJsonCurl($url,json_encode($dados));             
             echo $resultado;
         } catch (\Exception $e) {
             $mensagem = $e->getMessage();
             return redirect()->route('erro')->with('msg_erro', $mensagem);
         }
         
     }
     
     public function verificaSeCobrancaPagaNoPix($cobranca_id){  
         try {
             $url        = getenv("APP_URL_API"). "mercadopago/verificaSeCobrancaPagaNoPix/" . $cobranca_id;
             $resultado  = enviarGetCurl($url);
             
             echo       json_encode($resultado->data);
         } catch (\Exception $e) {
             return response()->json($e->getMessage());
         }
         
     }
    
}
