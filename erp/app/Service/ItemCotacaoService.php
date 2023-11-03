<?php
namespace App\Service;

use App\Models\Cotacao;
use App\Models\ItemCotacao;
use App\Models\ItemOrdemCompra;
use App\Models\OrdemCompra;
use App\Models\Solicitacao;
use Illuminate\Support\Facades\DB;

class ItemCotacaoService{
    public static function aprovar($item_cotacao_id, $cotacao_id){       
        $itemCotacao = ItemCotacao::find($item_cotacao_id);
        
        //Verifica se existe ordem de compra para o fornecedor e a cotação
        $ordem_compra = OrdemCompra::where("cotacao_id",$cotacao_id)->first();
        if(!$ordem_compra){
            $ordem_compra = OrdemCompra::create([
                "fornecedor_id"=>$itemCotacao->fornecedor_id,
                "cotacao_id"   => $cotacao_id,
                "status_ordem_compra_id"   => 2,
                "data_emissao" => hoje()
            ]);
        }
        
        //muda o status do vencedor para 3
        ItemCotacao::where("id", $item_cotacao_id)->update(["status_item_cotacao_id" => 3, "ordem_compra_id" =>$ordem_compra->id]);
        //muda o status dos rejeitos para 5
        ItemCotacao::where("solicitacao_id",$itemCotacao->solicitacao_id)->where("id", "<>", $item_cotacao_id)
                    ->update(["status_item_cotacao_id"=> 5]);
        
        //Inserir os itens da ordem de compra
        if(!ItemOrdemCompra::where(["ordem_compra_id" =>$ordem_compra->id, "produto_id"=> $itemCotacao->produto_id])->first()){
            ItemOrdemCompra::create([
                "ordem_compra_id"   =>$ordem_compra->id,
                "produto_id"        => $itemCotacao->produto_id,
                "qtde"              => $itemCotacao->qtde,
                "valor"             => $itemCotacao->valor_cotacao,
                "subtotal"          => $itemCotacao->subtotal,
            ]);
            
            $soma = ItemOrdemCompra::select(DB::raw('sum( subtotal ) as total'))->where("ordem_compra_id" , $ordem_compra->id)->first();
            $ordem_compra->update(["valor_total"=>$soma->total]);
           
        }
        
        //Adicionar o fornecedor e a ordem de compra na solicitação e mudar o status para 3
        Solicitacao::where("id",$itemCotacao->solicitacao_id )->update(["status_solicitacao_id" => 3,
            "ordem_compra_id" =>$ordem_compra->id,
            "fornecedor_id"   => $itemCotacao->fornecedor_id]);
        
        $todos= ItemCotacao::where(["cotacao_id"=>$cotacao_id,"ordem_compra_id"=>null])->get();

        if(count($todos) <=0 ){
            Cotacao::where("id", $cotacao_id)->update(["status_cotacao_id" => 4]);
        }
        
        
        
    }
}

