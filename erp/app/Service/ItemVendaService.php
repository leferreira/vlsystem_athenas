<?php
namespace App\Service;

use App\Models\GradeMovimento;
use App\Models\ItemVenda;
use App\Models\Produto;
use App\Models\Venda;

class ItemVendaService{
    public static function inserirItem($dados){ 
        $produto                 = Produto::find($dados->produto_id);
        $item                    = new \stdClass();       
        $item->venda_id          = $dados->venda_id;
        $item->produto_id        = $dados->produto_id;
        $item->quantidade        = getFloat($dados->quantidade);
        $item->unidade           = $dados->unidade;
        $item->valor             = $produto->valor_venda;
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
           
        ItemVenda::Create(objToArray($item));
     }
    
    public static function salvarItens($id, $itens, $faturas){        
        foreach($itens as $i){   
          ItemVenda::create([
                'venda_id'          => $id,
                'produto_id'        => (int) $i['codigo'],
                'quantidade'        =>  getFloat($i['quantidade']),
                'unidade'           =>  $i['unidade'],
                'valor'             =>  getFloat($i['valor']),
                'total_desconto_item' =>  getFloat($i['desconto']),
                'desconto_por_item' =>  getFloat($i['desconto_item']),
                'subtotal'          =>  getFloat($i['valor']) * getFloat($i['quantidade']),  
              'subtotal_liquido'    =>  (getFloat($i['valor']) - getFloat($i['desconto_por_item']))  * getFloat($i['quantidade']),
            ]);           
        }        
        Venda::somarTotal($id);    
        return true;
    }
    
    public static function gerarEstoqueDaVenda($venda){
        $itens = ItemVenda::where("venda_id", $venda->id)->get();     
        foreach($itens as $item){
            $produto        =  $item->produto;
            if($item->unidade ==$produto->fragmentacao_unidade){
                $quantidade = $item->quantidade / $produto->fragmentacao_qtde;
            }else{
                $quantidade = $item->quantidade;
            }
            
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = config("constantes.tipo_movimento.SAIDA_VENDA_PRODUTO");
            $mov->produto_id        = $item->produto_id;
            $mov->venda_id          = $item->venda_id;
            $mov->ent_sai           = 'S';
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $quantidade;
            $mov->valor_movimento   = $item->valor;
            $mov->subtotal_movimento= $item->subtotal;
            $mov->descricao         = "Saida Venda: #" . $item->venda_id;       
       
            
            $movimento = MovimentoService::inserir($mov);
            
            //modifica o status do tipo movimento da grade
            if($movimento){
                if($item->produto->usa_grade=="S"){
                    $grades = GradeMovimento::where("item_venda_id", $item->id)->get();
                    foreach($grades as $grade){
                        $grade->tipo_movimento_id = $mov->tipo_movimento_id;
                        $grade->save();
                    }
                }
            }
            
        }
        
    }
    
    public static function gerarEstoquePorItem($item){    
        $produto        = Produto::find($item->produto_id);        
        if($item->unidade == $produto->fragmentacao_unidade){
            $quantidade = $item->quantidade / $produto->fragmentacao_qtde;
        }else{
            $quantidade = $item->quantidade;
        }
        
        $mov                    = new \stdClass();
        $mov->tipo_movimento_id = config("constantes.tipo_movimento.SAIDA_VENDA_PRODUTO");
        $mov->produto_id        = $item->produto_id;
        $mov->venda_id          = $item->venda_id;
        $mov->ent_sai           = 'S';
        $mov->estorno           = 'N';
        $mov->data_movimento    = hoje();
        $mov->qtde_movimento    = $quantidade;
        $mov->valor_movimento   = $item->valor;
        $mov->subtotal_movimento= $mov->qtde_movimento * $mov->valor_movimento;
        $mov->descricao         = "Saida Venda: #" . $item->venda_id;
        if($produto->controlar_estoque=="S"){
            MovimentoService::inserir($mov);
        }
        
        
    }
}

