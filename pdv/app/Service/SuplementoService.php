<?php
namespace App\Service;

class SuplementoService
{
    public static function listaPorUsuario($id_usuario){
        $url         = getenv("APP_URL_API"). "pdvsuplemento/listaPorUsuario/". $id_usuario;
        $resultado   = enviarGetCurl($url);
        return $resultado->data;
    }
    
    public static function listaPorCaixa($id_caixa){
        $url         = getenv("APP_URL_API"). "pdvsuplemento/listaPorCaixa/". $id_caixa;     
        $resultado   = enviarGetCurl($url);
        return $resultado->data;
    }
    
    public static function salvar($valor){
        $url        = getenv("APP_URL_API"). "pdvsuplemento/salvar"; 
        
        $resultado  = enviarPostJsonCurl($url,json_encode($valor)); 
        $retorno    = json_decode($resultado);
        return $retorno->data;
    }
}

