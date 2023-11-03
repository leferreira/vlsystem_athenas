<?php
namespace App\Service;


class ProdutoService
{
    public static function buscaProduto($id_produto, $tipo=null){
        $url         = getenv("APP_URL_API"). "produto/produtoPorCodigo/".$id_produto."/".session("usuario_pdv_logado")->empresa_uuid;
        if($tipo == "barra"){
            $url    = getenv("APP_URL_API"). "produto/produtoPorCodigoBarra/".$id_produto."/".session("usuario_pdv_logado")->empresa_uuid;            
        }  
       
        $resultado   = enviarGetCurl($url);   
        return $resultado->data;
    }
    
    public static function pesquiserProdutoPorNome($q){
        $url         = getenv("APP_URL_API"). "produto/pesquisaPorNome/".$q."/".session("usuario_pdv_logado")->empresa_uuid;
        $resultado   = enviarGetCurl($url);   
        return $resultado->data;
    }
    
    
}

