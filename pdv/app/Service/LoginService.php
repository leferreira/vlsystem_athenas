<?php
namespace App\Service;

class LoginService{
    public static function logar($dados){
        $url        = getenv("APP_URL_API"). "login/logarPdv";        
        $resultado  = enviarPostJsonCurl($url,json_encode($dados)); 
        $retorno    = json_decode($resultado);       
        return $retorno->data;
        
        
    }
}

