<?php
namespace App\Service;

class PedidoClienteService{
    public static function filtro($dados){
        $url        = getenv("APP_URL_API"). "pedidocliente/filtro";       
        
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado); 
        return $retorno->data;
        
    }
    
    public static function salvar($dados){
        $url        = getenv("APP_URL_API"). "pedidocliente";     
        
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);   
        return $retorno->data;
        
    }
    
    public static function show($identificador){
        $url       = getenv("APP_URL_API"). "pedidocliente/".$identificador;     
        $retorno   = enviarGetCurl($url);
        if(isset($retorno->data)){
            return $retorno->data;
        } 
        
        return false;
    }
}

