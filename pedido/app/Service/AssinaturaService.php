<?php
namespace App\Service;

class AssinaturaService{ 
    public static function cobrancas($id){
        $url       = getenv("APP_URL_API"). "pedidocliente/cobrancas/". $id;
        
        $retorno   = enviarGetCurl($url);       
        return $retorno->data;
        
    }
}

