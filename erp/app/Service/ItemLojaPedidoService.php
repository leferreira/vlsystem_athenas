<?php
namespace App\Service;

use App\Models\LojaItemPedido;

class ItemLojaPedidoService{
    public static function inserirItem($dados){      
        $item                    = new \stdClass();       
        $item->pedido_id         = $dados->pedido_id;
        $item->produto_id        = $dados->produto_id;
        $item->quantidade        = getFloat($dados->quantidade);
        $item->unidade           =  $dados->unidade;
        $item->valor             =  getFloat($dados->valor);
        $item->subtotal          =  getFloat($dados->valor) * getFloat($dados->quantidade);
        $item->desconto_por_unidade = 0;
        
        if($dados->desconto_por_valor > 0){
            $item->desconto_por_unidade = $dados->desconto_por_valor;
        }
        
        if($dados->desconto_percentual > 0){
            $item->desconto_por_unidade = $dados->desconto_percentual * $item->valor * 0.01;
        }
        $item->total_desconto_item  =  $item->desconto_por_unidade * $item->quantidade;
        $item->subtotal_liquido     =  ($item->valor - $item->desconto_por_unidade )  * $item->quantidade;
           
        LojaItemPedido::Create(objToArray($item));
     }
    
  
}

