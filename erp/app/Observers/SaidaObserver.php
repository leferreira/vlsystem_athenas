<?php

namespace App\Observers;

use App\Models\Saida;
use App\Service\MovimentoService;

class SaidaObserver
{
    public function created(Saida $saida)
    {
        $produto        =  $saida->produto;
        if($saida->unidade ==$produto->fragmentacao_unidade){
            $quantidade = $saida->qtde_saida / $produto->fragmentacao_qtde;
        }else{
            $quantidade = $saida->qtde_saida;
        }
        
        $mov = new \stdClass();
        $mov->tipo_movimento_id = config("constantes.tipo_movimento.SAIDA_AVULSA");
        $mov->produto_id        = $saida->produto_id;
        $mov->saida_avulsa_id   = $saida->id;
        $mov->ent_sai           = 'S';
        $mov->estorno           = 'N';
        $mov->data_movimento    = $saida->data_saida;
        $mov->qtde_movimento    = $quantidade;
        $mov->valor_movimento   = $saida->valor_saida;
        $mov->subtotal_movimento= $saida->subtotal_saida;
        $mov->descricao         = "Saida Avulsa num: " . $saida->id;
        MovimentoService::inserir($mov);
    }
    
   
}
