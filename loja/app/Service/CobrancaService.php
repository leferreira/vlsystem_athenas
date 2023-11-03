<?php
namespace App\Service;

class CobrancaService{
    
    public static function lista($uuid){
        $url       = getenv("APP_URL_API"). "cobranca/lista/".$uuid;        
        $retorno   = enviarGetCurl($url);
        if(isset($retorno->data)){
            return $retorno->data;
        } 
        
        return false;
    }
    
    public static function detalhe($id, $uuid){
        $url       = getenv("APP_URL_API"). "cobranca/detalhe/".$id."/". $uuid;
        $retorno   = enviarGetCurl($url);       
        return $retorno->data;
        
    }
}

