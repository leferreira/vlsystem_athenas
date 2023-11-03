<?php
namespace App\Service;

class PedidoService{
    public static function criaPedido($dados){        
        $url        = getenv("APP_URL_API"). "loja/novoPedido";   
     /*  echo $url;
       i(json_encode($dados));*/
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);  
        return $retorno->data;        
    }
    
    public static function detalhe($uuid){
        $url       = getenv("APP_URL_API"). "loja/getPedidoPeloUuid/". $uuid;
        
        $retorno   = enviarGetCurl($url);
        return $retorno->data;
        
    }
    
    
    public static function addItem($dados){
        $url        = getenv("APP_URL_API"). "loja/addItem";
      /*  echo $url;
        i(json_encode($dados));*/
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        return $retorno->data;
    }
    
    public static function somaPeso($itens){
        $soma = 0;
        foreach($itens as $i){
            $soma += $i->quantidade * $i->produto->peso_bruto;
        }
        return $soma;
    }
    
    public static function somaDimensoes($itens){
        $dimensoes = new \stdClass();
        $dimensoes->comprimento = 0;
        $dimensoes->altura      = 0;
        $dimensoes->largura     = 0;
        
        
        foreach($itens as  $i){
            if($i->produto->comprimento > $dimensoes->comprimento){
                $dimensoes->comprimento = $i->produto->comprimento;
            }
            
            // if($i->produto->produto->altura > $data['altura']){
            $dimensoes->altura += $i->produto->altura;
            // }
            
            if($i->produto->largura > $dimensoes->largura){
                $dimensoes->largura = $i->produto->largura;
            }
            
            $dimensoes->largura = $dimensoes->largura;
        }
        return $dimensoes;
    }
   
}

