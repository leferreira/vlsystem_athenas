<?php
namespace App\Service;

use App\Models\ItemOrdemCompra;

class ItemOrdemCompraService{
    public static function salvarItens($id, $itens){
        
        foreach($itens as $i){
            $result = ItemOrdemCompra::create([
                'ordem_compra_id'   => $id,
                'produto_id'        => (int) $i['codigo'],
                'qtde'              =>  str_replace(",", ".", $i['quantidade']),
                'valor'             => str_replace(",", ".", $i['valor']),
                'subtotal'          => str_replace(",", ".", $i['valor']) * str_replace(",", ".", $i['quantidade'])
            ]);            
            
        }
        return true;
    }
}

