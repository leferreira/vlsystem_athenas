<?php
namespace App\Service;


class CaixaService{
    
    public static function listaNumeroCaixa(){
        $url         = getenv("APP_URL_API"). "pdvnumero/lista/".session("usuario_pdv_logado")->empresa_uuid;
        $resultado   = enviarGetCurl($url);
        return $resultado;
    }
    
    public static function detalhamento($id_caixa){
        $url         = getenv("APP_URL_API"). "pdvcaixa/detalhamento/".$id_caixa;
        $resultado   = enviarGetCurl($url);
        return $resultado;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public static function listaCaixa(){
       
        $url         = getenv("APP_URL_API"). "pdvcaixa/lista/".session("usuario_pdv_logado")->empresa_uuid."/";
        $resultado   = enviarGetCurl($url);
        return $resultado;
    }
    
    
    
    
    
    public static function listaCaixaAbertoPorUsuario($id_usuario){
        $url         = getenv("APP_URL_API"). "pdvcaixa/listaCaixaAbertoPorUsuario/".$id_usuario;
        $resultado   = enviarGetCurl($url);  
   
        return $resultado->data;        
    }
    
    public static function verificaSeTemCaixaAbertoPorUsuario($id_usuario){
        $url         = getenv("APP_URL_API"). "pdvcaixa/verificaSeTemCaixaAbertoPorUsuario/".$id_usuario;       
        $resultado   = enviarGetCurl($url);      
        return $resultado->data;
    }
    
    public static function abrirCaixa($caixa){
        $url        = getenv("APP_URL_API"). "pdvcaixa/abrir"; 
        $resultado  = enviarPostJsonCurl($url,json_encode($caixa));
        $retorno    = json_decode($resultado);
    
        return $retorno->data;
    }    
    
    public static function fechar($id_caixa, $id_usuario){
        $url         = getenv("APP_URL_API"). "pdvcaixa/fechar/".$id_caixa ."/".$id_usuario;
        $resultado   = enviarGetCurl($url);
        return $resultado;
    }
}

