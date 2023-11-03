<?php

namespace App\Observers;

use App\Models\FinContaReceber;
use App\Models\FinRecebimento;
use App\Service\MovimentoContaBancariaService;
use App\Models\Venda;

class RecebimentoObserver
{
    public function created(FinRecebimento $recebimento)
    { 
        MovimentoContaBancariaService::inserirMovimentoRecebimento($recebimento);       
        
        if($recebimento->conta_receber_id ){
            FinContaReceber::atualizar($recebimento->conta_receber_id);
            $conta_receber = $recebimento->conta_receber;
            if($conta_receber->venda_id){
                Venda::atualizarStatus($conta_receber->venda_id);
            }
        }
         
    }
    
   
}
