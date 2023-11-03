<?php
namespace App\Service;

use App\Models\ItemVendaRecorrente;
use App\Models\Produto;
use App\Models\ProdutoRecorrente;

class ItemVendaRecorrenteService{
    public static function inserirItem($dados){ 
        $item                       = new \stdClass();       
        $item->venda_recorrente_id = $dados->venda_recorrente_id ;
        $item->produto_recorrente_id        = $dados->produto_recorrente_id;
        $item->quantidade        = getFloat($dados->quantidade);
        $item->valor             = $dados->valor;
        $item->subtotal          = $item->valor * getFloat($dados->quantidade);
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
           
        ItemVendaRecorrente::Create(objToArray($item));
     }    
   
}

