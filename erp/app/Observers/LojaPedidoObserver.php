<?php

namespace App\Observers;

use App\Models\LojaPedido;
use Str;

class LojaPedidoObserver
{
    public function creating(LojaPedido $pedido)
    {
        $pedido->uuid = Str::uuid();
    }
    
   
    
}
