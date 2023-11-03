<?php
namespace App\Service;

class ConfiguracaoService{
    public  static function getConfiguracao(){
        $url         = getenv("APP_URL_API"). "lojaconfiguracao/".getenv("APP_ID_EMPRESA");
        $resultado   = enviarGetCurl($url);
        if(isset($resultado->data))
            return $resultado->data;        
        return $resultado;
    }
}

