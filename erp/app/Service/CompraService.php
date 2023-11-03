<?php
namespace App\Service;

use App\Models\Compra;
use App\Models\ItemCompra;
use App\Models\Produto;

class CompraService{
    public static function salvarItens($id, $itens){
        foreach($itens as $i){
            $prod = Produto::where('id', (int) $i['codigo'])->first();
            $result = ItemCompra::create([
                'compra_id' => $id,
                'produto_id' => (int) $i['codigo'],
                'quantidade' =>  str_replace(",", ".", $i['quantidade']),
                'valor_unitario' => str_replace(",", ".", $i['valor']),
                'unidade_compra' => $prod['unidade_compra'],
            ]);
            
            EstoqueService::pluStock((int) $i['codigo'],
                str_replace(",", ".", str_replace(",", ".", $i['quantidade'])),
                str_replace(",", ".", str_replace(",", ".", $i['valor'])));
            
        }
        return true;
    }
    
    public static function somaCompraMensal(){
        $compras = Compra::all();
        $temp = [];
        $soma = 0;
        $mesAnterior = null;
        $anoAnterior = null;
        
        foreach($compras as $key => $c){
            $date = $c->created_at;
            $mes = substr($date, 5, 2);
            $ano = substr($date, 0, 4);            
            
            if($mesAnterior != $mes){
                $temp["Mes: ".$mes."/$ano"] = $c->valor;
            }else{
                $temp["Mes: ".$mesAnterior."/$anoAnterior"] += $c->valor;
                
            }
            $mesAnterior = $mes;
            $anoAnterior = $ano;
        }
        
        return $temp;
    }
}

