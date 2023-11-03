<?php
namespace App\Service;

class NotaFiscalService{
    public static function transmitirNfce($id_nfce){
        $url         = getenv("APP_URL_API"). "pdv/transmitirNfce/".$id_nfce;
        $resultado   = enviarGetCurl($url);
        return $resultado;
    }
    
    public static function transmitirPelaVenda($id_venda){
        $url         = getenv("APP_URL_API"). "pdv/transmitirPelaVenda/".$id_venda;
        $resultado   = enviarGetCurl($url);
        return $resultado;
    }
    
    public static function verificarRequisito($empresa_uuid){
        $url         = getenv("APP_URL_API"). "pdv/verificarRequisitos/".$empresa_uuid;        
        $resultado   = enviarGetCurl($url);      
        return $resultado;
    }
}

