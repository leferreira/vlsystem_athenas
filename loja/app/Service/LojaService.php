<?php
namespace App\Service;

class LojaService{
    public  static function home($pagina, $subcategoria_id=null, $url_produto=null, $uuid_pedido=null, $q=null){     
        $dados             = new \stdClass();
        $dados->pedido_id  = session('pedido') ?? null;
        $dados->cliente_id = session('usuario_loja_logado')->cliente_id ?? null;
        $dados->token      = getenv("APP_ID_EMPRESA");
        $dados->subcategoria_id = $subcategoria_id;
        $dados->pagina     = $pagina;
        $dados->url_produto= $url_produto;
        $dados->q          = $q;
        $dados->uuid_pedido  = $uuid_pedido; //o pedido do cliene para detalhe;
 
        $url        = getenv("APP_URL_API"). "loja/home";

        
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);

        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    public static function atualizarItem($id, $qtde){
        $dados             = new \stdClass();
        $dados->pedido_id  = session('pedido') ?? null;
        $dados->cliente_id = session('usuario_loja_logado')->cliente_id ?? null;
        $dados->token      = getenv("APP_ID_EMPRESA");
        $dados->id         = $id;
        $dados->qtde       = $qtde;
        
        $url        = getenv("APP_URL_API"). "loja/atualizarItem";
      /*  echo $url;
         echo json_encode($dados);
         exit;*/
        
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        
        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    public static function excluirItem($id){
        $dados             = new \stdClass();
        $dados->pedido_id  = session('pedido') ?? null;
        $dados->cliente_id = session('usuario_loja_logado')->cliente_id ?? null;
        $dados->token      = getenv("APP_ID_EMPRESA");
        $dados->id         = $id;
        
        $url        = getenv("APP_URL_API"). "loja/excluirItem";
       /* echo $url;
        echo json_encode($dados);
        exit;*/
        
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        
        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    
    public  static function salvarEnderecoCliente($dados){
        $url        = getenv("APP_URL_API"). "loja/salvarEnderecoCliente";       
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        return $retorno->data;
    }
    
    public  static function getEnderecoPeloId($id){
        $url         = getenv("APP_URL_API"). "loja/getEnderecoPeloId/". $id;
        
        $resultado   = enviarGetCurl($url);
        if(!isset($resultado->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $resultado->data;
    }
    
    public static function finalizarPedido($uuid_pedido, $forma_pago){
        $dados                  = new \stdClass();
        $dados->cliente_id      = session('usuario_loja_logado')->cliente_id ?? null;
        $dados->token           = getenv("APP_ID_EMPRESA");
        $dados->uuid_pedido     = $uuid_pedido; //o pedido do cliene para detalhe;
        $dados->forma_pagto     = $forma_pago;
        
        $url                    = getenv("APP_URL_API"). "loja/finalizarPedido";  
    
        $resultado              = enviarPostJsonCurl($url,json_encode($dados));
        $retorno                = json_decode($resultado);
        
        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public  static function subcategoria($subcategoria_id){
        $url         = getenv("APP_URL_API"). "loja/subcategoria/".getenv("APP_ID_EMPRESA") ."/". $subcategoria_id;     
        $resultado   = enviarGetCurl($url);
        
        if(!isset($resultado->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $resultado->data;
    }
    public  static function pesquisa($q){
        $url         = getenv("APP_URL_API"). "loja/pesquisa/". getenv("APP_ID_EMPRESA") ."/".$q;
        
        $resultado   = enviarGetCurl($url);
        
        if(!isset($resultado->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $resultado->data;
    }
    
    public  static function getPedidoPeloUuid($uuid){
        $url         = getenv("APP_URL_API"). "loja/getPedidoPeloUuid/". $uuid;   
   
        $resultado   = enviarGetCurl($url);        
        if(!isset($resultado->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $resultado->data;
    }       
    
    public  static function retormarPedidoPeloPdv($uuid){
        $dados                  = new \stdClass();
        
        $dados->empresa_uuid    = getenv("APP_ID_EMPRESA");
        $dados->uuid_pdv        = $uuid;
        $dados->cliente_id      = session('usuario_loja_logado')->cliente_id ?? null;
        $url                    = getenv("APP_URL_API"). "loja/retormarPedidoDaLojaPeloPdv";
       /* echo $url;
        echo json_encode($dados);
        exit;*/
        $resultado              = enviarPostJsonCurl($url,json_encode($dados));
        $retorno                = json_decode($resultado);      
        return $retorno->data;;
    }
    public  static function detalhe($uuid){
        $url         = getenv("APP_URL_API"). "loja/detalhe/".$uuid;   
        $resultado   = enviarGetCurl($url);
        
        if(!isset($resultado->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $resultado->data;
    }
    
    
    public  static function carrinho(){
        $pedido                 = session('pedido') ?? null;     
        $cliente_id             = session('usuario_loja_logado')->cliente_id ?? null;
        $dados                  = new \stdClass();
        $dados->pedido_id       = $pedido;
        $dados->cliente_id      = $cliente_id;
        $dados->empresa_uuid    = getenv("APP_ID_EMPRESA");      

        $url        = getenv("APP_URL_API"). "loja/carrinho";     
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado); 
       
        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    public  static function perfil(){
        $pedido                 = session('pedido') ?? null;
        $cliente_id             = session('usuario_loja_logado')->cliente_id ?? null;
        $dados                  = new \stdClass();
        $dados->pedido_id       = $pedido;
        $dados->cliente_id      = $cliente_id;
        $dados->empresa_uuid    = getenv("APP_ID_EMPRESA");
        
        $url        = getenv("APP_URL_API"). "loja/perfil";         
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        
        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    public  static function novoCliente($dados){        
        $url        = getenv("APP_URL_API"). "loja/novoCliente"; 
        
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        return $retorno->data;
    }
    
    
    
    public  static function setarEnderecoFrete($dados){
        $url        = getenv("APP_URL_API"). "loja/setarEnderecoFrete";        
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        return $retorno->data;
    }
    
    public static function logar($dados){
        $url        = getenv("APP_URL_API"). "loja/logar";       
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        $cliente    = $retorno->data;
        if($cliente){
            $cli = (object) [
                'cliente_id'    => $cliente->id,
                'nome'          => $cliente->nome_razao_social,
                'email'         => $cliente->email,
                'start'         => date('H:i:s')
            ];
            session(['usuario_loja_logado' => $cli]);
        }else{
            session()->forget('usuario_loja_logado');
        }        
        return $cliente;
    }
    
}

