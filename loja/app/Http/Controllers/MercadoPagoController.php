<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class MercadoPagoController extends Controller{


    public function pix(Request $request){
        $dados                  = $request->all();
       // $dados["empresa_id"]    = getenv("APP_ID_EMPRESA");
        $dados["origem"]        = "loja_virtual";

        $url                    = getenv("APP_URL_API"). "mercadopago/pix";
       /* echo $url;
        echo json_encode($dados);
        exit;*/
        $resultado              = enviarPostJsonCurl($url,json_encode($dados));
        echo $resultado;
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

     public function verificaSePedidoPagoNoPix($pedido_id){
         try {
             $url        = getenv("APP_URL_API"). "mercadopago/verificaSePedidoPagoNoPix/" . $pedido_id;
             $resultado  = enviarGetCurl($url);

             echo       json_encode($resultado->data);
         } catch (\Exception $e) {
             return response()->json($e->getMessage());
         }

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
