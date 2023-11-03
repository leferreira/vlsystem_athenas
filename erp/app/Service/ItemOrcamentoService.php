<?php
namespace App\Service;

use App\Models\ItemOrcamento;

class ItemOrcamentoService{
    public static function inserirItem($dados){
        
        $item                    = new \stdClass();
        $item->orcamento_id      = $dados->orcamento_id;
        $item->produto_id        = $dados->produto_id;
        $item->quantidade        = getFloat($dados->quantidade);
        $item->unidade           =  $dados->unidade;
        $item->valor             =  getFloat($dados->valor);
        $item->subtotal          =  getFloat($dados->valor) * getFloat($dados->quantidade);
        $item->desconto_por_unidade = 0;
        $item->desconto_por_valor = getFloat($dados->desconto_por_valor);
        $item->desconto_percentual = getFloat($dados->desconto_percentual);
        
        if($item->desconto_por_valor > 0){
            $item->desconto_por_unidade = $item->desconto_por_valor;
        }
       
        if($item->desconto_percentual > 0){
            $item->desconto_por_unidade = $item->desconto_percentual * $item->valor * 0.01;
        }
     
        $item->total_desconto_item  =  $item->desconto_por_unidade * $item->quantidade;
        $item->subtotal_liquido     =  ($item->valor - $item->desconto_por_unidade )  * $item->quantidade;
        
        ItemOrcamento::Create(objToArray($item));
    }    
    
    
}

