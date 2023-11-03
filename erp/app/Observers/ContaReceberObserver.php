<?php

namespace App\Observers;

use App\Models\FinContaReceber;

class ContaReceberObserver
{
    public function creating(FinContaReceber $receber)
    {   
        $receber->usuario_id              = auth()->user()->id;
        $receber->status_id               = config("constantes.status.ABERTO");      
        $receber->total_juros             = 0;
        $receber->total_multa             = 0;
        $receber->total_desconto          = 0;
        $receber->total_liquido           = $receber->valor;
        $receber->total_recebido          = 0;
        $receber->total_restante          = $receber->valor;
    }    
   
}
