<?php
namespace App\Service;

class SangriaService
{
    public static function salvar($valor){
        $url        = getenv("APP_URL_API"). "pdvsangria/salvar";
       
        $resultado  = enviarPostJsonCurl($url,json_encode($valor));
        $retorno    = json_decode($resultado);
        return $retorno->data;
    }
    
    public static function listaPorCaixa($id_caixa){
        $url         = getenv("APP_URL_API"). "pdvsangria/listaPorCaixa/". $id_caixa;
        $resultado   = enviarGetCurl($url);
        return $resultado->data;
    }
    
    public static function listaPorUsuario($id_usuario){
        $url         = getenv("APP_URL_API"). "pdvsangria/listaPorUsuario/". $id_usuario;
        $resultado   = enviarGetCurl($url);
        return $resultado->data;
    }
    
    
    
    
}

