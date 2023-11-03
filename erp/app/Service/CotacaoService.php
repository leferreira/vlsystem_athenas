<?php
namespace App\Service;

use App\Models\ItemCotacao;
use App\Models\SolicitacaoCotacao;

class CotacaoService{
    public static function listaComparacaoPrecos($cotacao_id){
        $solicitacoes   = SolicitacaoCotacao::where("cotacao_id",$cotacao_id)->with('solicitacao')->get();
        $menoresPrecos  = ItemCotacao::agrupaMenorPreco($cotacao_id);
      
        if($menoresPrecos){
            foreach($menoresPrecos as $m){
                $menor[$m->solicitacao_id] = $m->menor;
            }
        }
        
       foreach($solicitacoes as $solicitacao){
            $solicitacao->itens = ItemCotacao::where(["cotacao_id"=>$cotacao_id, "solicitacao_id" => $solicitacao->solicitacao_id])->get();
            if(!$solicitacao->id_fornecedor){
                $solicitacao->menor_preco = 
                    ItemCotacao::where(["cotacao_id" =>$cotacao_id,"solicitacao_id"=> $solicitacao->solicitacao_id, "valor_cotacao"=> $menor[$solicitacao->solicitacao_id]])->first();
            }else{
                $solicitacao->menor_preco = ItemCotacao::where("solicitacao_id",$solicitacao->solicitacao_id)->first();
            }
            
        }
       
        return $solicitacoes;
    }
}

