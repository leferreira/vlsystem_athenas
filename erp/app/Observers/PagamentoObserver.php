<?php

namespace App\Observers;

use App\Models\FinContaPagar;
use App\Models\FinPagamento;
use App\Service\MovimentoContaBancariaService;

class PagamentoObserver
{
    public function created(FinPagamento $pagamento)
    { 
       
        MovimentoContaBancariaService::inserirMovimentoPagamento($pagamento);       
        
        if($pagamento->conta_pagar_id ){
            FinContaPagar::atualizar($pagamento->conta_pagar_id);
        }
         
    }
    
   
}
