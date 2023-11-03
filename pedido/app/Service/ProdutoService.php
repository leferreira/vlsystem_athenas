<?php
namespace App\Service;

class ProdutoService{
    
    public static function pesquisaPorNome($nome){
        $url       = getenv("APP_URL_API"). "produto/pesquisaPorNome/".$nome ."/".session("usuario_logado")->token;   
      
        $retorno   = enviarGetCurl($url);
        if(isset($retorno->data)){
            return $retorno->data;
        } 
        
        return false;
    }
}

