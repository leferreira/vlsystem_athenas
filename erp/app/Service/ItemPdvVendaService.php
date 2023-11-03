<?php
namespace App\Service;

use App\Models\PdvItemVenda;

class ItemPdvVendaService{
    
    public static function gerarEstoqueDaVenda($venda){
        $itens = PdvItemVenda::where("venda_id", $venda->id)->get();     
        foreach($itens as $item){
            $produto        =  $item->produto;
            if($item->unidade ==$produto->fragmentacao_unidade){
                $quantidade = $item->quantidade / $produto->fragmentacao_qtde;
            }else{
                $quantidade = $item->quantidade;
            }
            
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = config("constantes.tipo_movimento.SAIDA_VENDA_PDV");
            $mov->produto_id        = $item->produto_id;
            $mov->venda_id          = $item->venda_id;
            $mov->ent_sai           = 'S';
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $quantidade;
            $mov->valor_movimento   = $item->valor;
            $mov->subtotal_movimento= $item->subtotal;
            $mov->descricao         = "Saida Pdv: #" . $item->venda_id;        
            MovimentoService::inserir($mov);
            
        }
        
    }
}

