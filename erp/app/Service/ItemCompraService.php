<?php
namespace App\Service;

use App\Models\ItemCompra;
use App\Models\Produto;
use App\Models\GradeMovimento;

class ItemCompraService{
    public static function inserirItem($dados){
        $produto                 = Produto::find($dados->produto_id);        
        if(!verificarEValidarProdutoGrade($produto)){
            throw(new \Exception("O produto " . $produto->nome ." usa grade e o estoque das grades está diferente do estoque do produto, regularize essa situação para efetuar esta operação"));
        }
        
       
        $item                       = new \stdClass();
        $item->compra_id            = $dados->compra_id;
        $item->produto_id           = $dados->produto_id;
        $item->quantidade           = getFloat($dados->quantidade);
        $item->unidade              = $dados->unidade;
        $item->valor_unitario       = getFloat($dados->valor);
        $item->subtotal             = $item->valor_unitario * getFloat($dados->quantidade);
        $item->desconto_por_unidade = 0;
        $item->desconto_por_valor = getFloat($dados->desconto_por_valor);
        $item->desconto_percentual = getFloat($dados->desconto_percentual);
        
        if($item->desconto_por_valor > 0){
            $item->desconto_por_unidade = $item->desconto_por_valor;
        }
        
        if($item->desconto_percentual > 0){
            $item->desconto_por_unidade = $item->desconto_percentual * $item->valor_unitario * 0.01;
        }
        $item->total_desconto_item  =  $item->desconto_por_unidade * $item->quantidade;
        $item->subtotal_liquido     =  ($item->valor_unitario - $item->desconto_por_unidade )  * $item->quantidade;
        
        ItemCompra::Create(objToArray($item));
    }
    
    public static function salvarItens($id, $itens){        
        foreach($itens as $i){
            ItemCompra::create([
                'compra_id'     => $id,
                'produto_id'    => (int) $i['codigo'],
                'quantidade'    =>  str_replace(",", ".", $i['quantidade']),
                'valor_unitario'=> str_replace(",", ".", $i['valor']),
                'subtotal'      => str_replace(",", ".", $i['valor']) * str_replace(",", ".", $i['quantidade']) ,
            ]);         
         }
        return true;
    }
    
    public static function gerarEstoqueDaCompra($compra){
        $itens = ItemCompra::where("compra_id", $compra->id)->get();
        foreach($itens as $item){
            $produto        =  $item->produto;
            if($item->unidade!=null && $item->unidade == $produto->fragmentacao_unidade){
                $quantidade = $item->quantidade / $produto->fragmentacao_qtde;
            }else{
                $quantidade = $item->quantidade;
            }
            
            $mov                    = new \stdClass();
            if($compra->chave){
                $mov->tipo_movimento_id = config("constantes.tipo_movimento.ENTRADA_IMPORTACAO_XML");
            }else{
                $mov->tipo_movimento_id = config("constantes.tipo_movimento.ENTRADA_COMPRA_MANUAL");
            }            
            $mov->produto_id        = $item->produto_id;
            $mov->compra_id         = $item->compra_id;
            $mov->ent_sai           = 'E';
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $quantidade;
            $mov->valor_movimento   = $item->valor_unitario;
            $mov->subtotal_movimento= $item->subtotal;
            $mov->descricao         = "Entrada Compra Manual: #" . $item->compra_id;   
          
            $movimento = MovimentoService::inserir($mov);
            
            //modifica o status do tipo movimento da grade
            if($movimento){
                if($item->produto->usa_grade=="S"){
                    $grades = GradeMovimento::where("item_compra_id", $item->id)->get();
                    foreach($grades as $grade){
                        $grade->tipo_movimento_id = $mov->tipo_movimento_id;
                        $grade->save();
                    }
                }
            }
            
        }
        
    }
    
    public static function salvarItensDaNfe($id_compra, $itens){
        foreach($itens as $i){
            if($i->produto_id=="-1"){
                $prod                   = new \stdClass();
                $prod->nome			    = $i->xProd;
                $prod->gtin             = $i->cEAN;
                $prod->tributacao_id    = 1;
                $prod->categoria_id	    = $i->categoria_id;
                $prod->unidade		    = $i->unidade;
                $prod->valor_venda	    = $i->vUnCom;
                $prod->estoque_minimo   = 10;
                $prod->estoque_maximo   = 10;
                $prod->estoque_inicial  = 10;
                $prod->cfop			    = $i->CFOP;
                $prod->ncm			    = $i->NCM;
                $prod->cest			    = $i->CEST;
                $prod->cbenef		    = $i->cBenef;
                $prod->tipi			    = $i->EXTIPI;
                
                $produto            = Produto::Create(objToArray($prod));
            }else{
                $produto            = Produto::where('id', $i->produto_id)->first();
            }
            $result = ItemCompra::create([
                'compra_id'     => $id_compra,
                'produto_id'    => $produto->id,
                'quantidade'    => $i->qCom,
                'valor_unitario'=> $i->vUnCom,
                'unidade_compra'=> $i->unidade,
            ]);            
            EstoqueService::pluStock($produto->id, $i->qCom, $i->vUnCom);            
        }
        return true;
    }
}

