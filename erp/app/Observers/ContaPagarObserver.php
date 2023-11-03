<?php

namespace App\Observers;

use App\Models\FinContaPagar;

class ContaPagarObserver
{
    public function creating(FinContaPagar $pagar)
    {   
        $pagar->usuario_id              = auth()->user()->id;
        $pagar->status_id               = config("constantes.status.ABERTO");      
        $pagar->total_juros             = 0;
        $pagar->total_multa             = 0;
        $pagar->total_desconto          = 0;
        $pagar->total_liquido           = $pagar->valor;
        $pagar->total_recebido          = 0;
        $pagar->total_restante          = $pagar->valor;
    }    
   
}
